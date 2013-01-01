<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\DependencyInjection;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * ChillDev ViewHelpers extensions.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ChillDevViewHelpersExtension extends Extension
{
    /**
     * {@inheritDoc}
     * @version 0.1.0
     * @since 0.0.1
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        // templating helpers
        $loader->load('services.xml');

        // enable XHTML Content-Type fix
        if ($config['xhtml']) {
            $loader->load('xhtml.xml');
        }

        // enable serializer helper only on-demand
        if ($config['serializer']) {
            $loader->load('serializer.xml');
        }

        // set up title
        if (isset($config['title']['separator'])) {
            $container->setParameter('chilldev.viewhelpers.title.separator', $config['title']['separator']);
        }
        if (isset($config['title']['base'])) {
            $container->getDefinition('chilldev.viewhelpers.helper.title')->addMethodCall(
                'append',
                [$config['title']['base']]
            );
        }

        // initial keywords
        if (\count($config['keywords']) > 0) {
            $container->getDefinition('chilldev.viewhelpers.container.keywords')->addMethodCall(
                'append',
                $config['keywords']
            );
        }

        // initial <meta> tags
        $metas = $container->getDefinition('chilldev.viewhelpers.helper.meta');
        foreach ($config['meta'] as $meta) {
            // choose right container
            if (isset($meta['name'])) {
                $key = $meta['name'];
                $method = 'setMetaName';
            } elseif (isset($meta['property'])) {
                $key = $meta['property'];
                $method = 'setProperty';
            } else {
                $key = $meta['http_equiv'];
                $method = 'setHttpEquiv';
            }

            $metas->addMethodCall($method, [$key, $meta['content']]);
        }

        // pre-defined <link> elements
        $links = $container->getDefinition('chilldev.viewhelpers.helper.link');
        foreach ($config['links'] as $link) {
            $links->addMethodCall('add', [$link['href'], $link['rels'], $link['type'], $link['media']]);
        }
        // pre-defined <link> elements for stylesheets
        foreach ($config['stylesheets'] as $stylesheet) {
            $links->addMethodCall('addStylesheet', [$stylesheet['href'], $stylesheet['media'], $stylesheet['type']]);
        }

        $flows = [
            'normal' => Element::FLOW_DEFAULT,
            'defer' => Element::FLOW_DEFER,
            'async' => Element::FLOW_ASYNC,
        ];

        // pre-defined <script> elements
        $scripts = $container->getDefinition('chilldev.viewhelpers.helper.script');
        foreach ($config['scripts'] as $script) {
            $scripts->addMethodCall(
                'add',
                [$script['src'], $script['type'], $flows[$script['flow']], $script['charset']]
            );
        }

        // pre-defined xmlns="" attributes
        $xmlns = $container->getDefinition('chilldev.viewhelpers.helper.xmlns');
        foreach ($config['xml_namespaces'] as $namespace => $alias) {
            $xmlns->addMethodCall('offsetSet', [$namespace, $alias]);
        }
    }

    /**
     * {@inheritdoc}
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getAlias()
    {
        return 'chilldev_viewhelpers';
    }
}
