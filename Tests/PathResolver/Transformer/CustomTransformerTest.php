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

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\CustomTransformer;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class CustomTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function transform()
    {
        $prefix = 'foo/';
        $path = 'bar';

        $transformer = new CustomTransformer($prefix);

        $this->assertEquals($prefix . $path, $transformer->transform($path), 'CustomTransformer::transform() should prepand path with base URL.');
    }
}
