<?php

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
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
 * @package ChillDevViewHelpersBundle
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

        return $treeBuilder;
    }
}
