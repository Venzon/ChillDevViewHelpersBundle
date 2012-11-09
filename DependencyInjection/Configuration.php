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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * ChillDev.ViewHelpers configuration handler.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('chilldev_viewhelpers');

        // define parameters
        $rootNode
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
            ->end();

        return $treeBuilder;
    }
}
