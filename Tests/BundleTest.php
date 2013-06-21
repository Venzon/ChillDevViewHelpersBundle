<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\ChillDevViewHelpersBundle;
use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\ChillDevViewHelpersExtension;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class BundleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Check if bundle registers own extension.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function ownExtension()
    {
        $extension = (new ChillDevViewHelpersBundle())->getContainerExtension();
        $this->assertEquals('chilldev_viewhelpers', $extension->getAlias(), 'ChillDevViewHelpersBundle::getContainerExtension() should return bundle\'s extension.');
    }

    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function build()
    {
        $mock = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerBuilder', array('addCompilerPass'));
        $mock->expects($this->once())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf('ChillDev\\Bundle\\ViewHelpersBundle\\DependencyInjection\\Compiler\\PathTransformersPass'));

        (new ChillDevViewHelpersBundle())->build($mock);
    }
}
