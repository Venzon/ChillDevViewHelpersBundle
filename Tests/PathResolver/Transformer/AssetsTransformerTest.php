<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\PathResolver\Transformer;

use stdClass;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\AssetsTransformer;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class AssetsTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function transform()
    {
        $mock = $this->getMock('Symfony\\Component\\Templating\\Helper\\CoreAssetsHelper', array('getUrl'), array(), '', false);
        $before = new stdClass();
        $after = new stdClass();

        $mock->expects($this->once())
            ->method('getUrl')
            ->with($this->identicalTo($before), $this->isNull())
            ->will($this->returnValue($after));

        $transformer = new AssetsTransformer($mock);

        $this->assertSame($after, $transformer->transform($before), 'AssetsTransformer::transform() should use assets helper for generating URLs.');
    }

    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function transformWithPackage()
    {
        $mock = $this->getMock('Symfony\\Component\\Templating\\Helper\\CoreAssetsHelper', array('getUrl'), array(), '', false);
        $before = new stdClass();
        $after = new stdClass();
        $package = new stdClass();

        $mock->expects($this->once())
            ->method('getUrl')
            ->with($this->identicalTo($before), $this->identicalTo($package))
            ->will($this->returnValue($after));

        $transformer = new AssetsTransformer($mock, $package);

        $this->assertSame($after, $transformer->transform($before), 'AssetsTransformer::transform() should use specified assets package if given.');
    }
}
