<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * ChillDev ViewHelpers extensions.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ChillDevViewHelpersExtension extends Extension
{
    /**
     * {@inheritDoc}
     * @version 0.0.1
     * @since 0.0.1
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        // templating helpers
        $loader->load('services.xml');

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
