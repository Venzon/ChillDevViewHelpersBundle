<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Container;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Meta;
use ChillDev\Bundle\ViewHelpersBundle\Tests\BaseTemplatingTest;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class MetaTest extends BaseTemplatingTest
{
    /**
     * Check if attribute passed to constructor is remembered.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function attributeFromConstructor()
    {
        $attribute = 'foo';

        $meta = new Meta($this->templating, $this->checker, $this->markup, $attribute);

        $this->assertEquals($attribute, $meta->getAttribute(), 'Element::__construct() should set attribute passed as argument.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function toStringConversion()
    {
        $attribute = 'foo';
        $key = 'bar';
        $value = 'baz';

        $meta = new Meta($this->templating, $this->checker, $this->markup, $attribute);
        $meta[$key] = $value;

        $this->assertEquals('<meta ' . $attribute . '="' . $key . '" content="' . $value . '">', $meta->__toString(), 'Meta::__toString() should generate <meta> element snippet.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.1
     */
    public function toStringCasting()
    {
        $attribute = 'foo';
        $key = 'bar';
        $value = 'baz';

        $meta = new Meta($this->templating, $this->checker, $this->markup, $attribute);
        $meta[$key] = $value;

        $this->assertEquals('<meta ' . $attribute . '="' . $key . '" content="' . $value . '">', (string) $meta->__toString(), 'Meta::__toString() should handle conversion to string.');
    }
}
