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

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\RequestTransformer;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class RequestTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function transform()
    {
        $basePath = 'foo/';
        $path = 'bar';

        $request = $this->getMock('stdClass', array('getBaseUrl'));
        $request->expects($this->once())
            ->method('getBaseUrl')
            ->will($this->returnValue($basePath));

        $mock = $this->getMock('Symfony\\Bundle\\FrameworkBundle\\Templating\\GlobalVariables', array('getRequest'), array(), '', false);
        $mock->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        $transformer = new RequestTransformer($mock);

        $this->assertSame($basePath . $path, $transformer->transform($path), 'RequestTransformer::transform() should use request base URL for generating URLs.');
    }
}
