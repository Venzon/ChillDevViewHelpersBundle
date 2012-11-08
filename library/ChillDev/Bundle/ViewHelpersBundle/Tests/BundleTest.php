<?php

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\ChillDevViewHelpersBundle;
use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\ChillDevViewHelpersExtension;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */
class BundleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Check if bundle registers own extension.
     *
     * @test
     */
    public function ownExtension()
    {
        $extension = (new ChillDevViewHelpersBundle())->getContainerExtension();
        $this->assertEquals('chilldev_viewhelpers', $extension->getAlias());
    }
}
