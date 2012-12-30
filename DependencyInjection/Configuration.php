<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ChillDev.ViewHelpers configuration handler.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     * @version 0.1.0
     * @since 0.0.1
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('chilldev_viewhelpers');

        // define parameters
        $rootNode
            ->children()
                ->booleanNode('xhtml')
                    ->defaultFalse()
                    ->info('application/xhtml+xml Content-Type switch')
                ->end()
            ->end()
            ->children()
                ->arrayNode('title')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('separator')
                            ->defaultNull()
                            ->info('<title> parts separator')
                        ->end()
                        ->scalarNode('base')
                            ->defaultNull()
                            ->info('initial <title> part')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->fixXmlConfig('link')
            ->children()
                ->arrayNode('links')
                    ->prototype('array')
                        ->fixXmlConfig('rel')
                        ->children()
                            ->scalarNode('href')
                                ->isRequired()
                            ->end()
                            ->arrayNode('rels')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->beforeNormalization()
                                    ->ifTrue(
                                        function ($value) {
                                            return !\is_array($value);
                                        }
                                    )
                                    ->then(
                                        function ($value) {
                                            return [$value];
                                        }
                                    )
                                ->end()
                                ->prototype('scalar')
                                ->end()
                            ->end()
                            ->scalarNode('type')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('media')
                                ->defaultNull()
                            ->end()
                        ->end()
                    ->end()
                    ->info('<link> tags definitions')
                ->end()
            ->end()
            ->fixXmlConfig('stylesheet')
            ->children()
                ->arrayNode('stylesheets')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('href')
                                ->isRequired()
                            ->end()
                            ->scalarNode('type')
                                ->defaultValue('text/css')
                            ->end()
                            ->scalarNode('media')
                                ->defaultNull()
                            ->end()
                        ->end()
                    ->end()
                    ->info('<link> stylesheets definitions')
                ->end()
            ->end()
            ->fixXmlConfig('keyword')
            ->children()
                ->arrayNode('keywords')
                    ->prototype('scalar')
                    ->end()
                    ->example(['foo', 'bar'])
                    ->info('initial website <meta> keywords')
                ->end()
            ->end()
            ->children()
                ->arrayNode('meta')
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('name')
                                ->cannotBeEmpty()
                                ->info('for meta tags by name="" attribute')
                            ->end()
                            ->scalarNode('property')
                                ->cannotBeEmpty()
                                ->info('for meta tags by property="" attribute')
                            ->end()
                            ->scalarNode('http_equiv')
                                ->cannotBeEmpty()
                                ->info('for meta tags by http-equiv="" attribute')
                            ->end()
                            ->scalarNode('content')
                                ->isRequired()
                            ->end()
                        ->end()
                        ->validate()
                            ->ifTrue(
                                function ($value) {
                                    return (int) isset($value['name'])
                                        + (int) isset($value['property'])
                                        + (int) isset($value['http_equiv']) > 1;
                                }
                            )
                            ->thenInvalid(
                                '<meta> may have only one of "name", "property" and "http-equiv" attributes defined.'
                            )
                        ->end()
                        ->validate()
                            ->ifTrue(
                                function ($value) {
                                    return !(isset($value['name'])
                                            || isset($value['property'])
                                            || isset($value['http_equiv'])
                                        );
                                }
                            )
                            ->thenInvalid(
                                '<meta> must have one of "name", "property" and "http-equiv" attributes defined.'
                            )
                        ->end()
                    ->end()
                    ->info('<meta> tag definitions')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
