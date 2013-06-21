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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\PathResolver;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\CustomTransformer;
use ChillDev\Bundle\ViewHelpersBundle\PathResolver\PathResolver;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class PathResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function resolve()
    {
        $prefix = 'foo';
        $basePath = 'bar/';

        $transformer = new CustomTransformer($basePath);

        $resolver = new PathResolver();
        $resolver->registerTransformer($prefix, $transformer);

        $path = 'baz';
        $this->assertEquals($basePath . $path, $resolver->resolve('@' . $prefix . ':' . $path), 'PathResolver::resolve() should resolve registered prefix.');

        $path = '@quux:qux';
        $this->assertEquals($path, $resolver->resolve($path), 'PathResolver::resolve() should not resolve unregistered prefix.');

        $path = './qux';
        $this->assertEquals($path, $resolver->resolve($path), 'PathResolver::resolve() should resolve paths without prefix.');
    }
}
