<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Utils;

use ChillDev\Bundle\ViewHelpersBundle\Tests\BaseTemplatingTest;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class MarkupTest extends BaseTemplatingTest
{
    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function shortTag()
    {
        $element = 'script';
        $markup = new Markup($this->templating);

        $this->assertEquals('<' . $element . '>', $markup->generateElement($element, [], false), 'Markup::generateElement() should generate empty HTML tag.');
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function shortTagWithAttribues()
    {
        $element = 'script';
        $attr1 = 'foo';
        $value1 = 'bar';
        $attr2 = 'baz';
        $value2 = 'qux';
        $markup = new Markup($this->templating);

        $this->assertEquals('<' . $element . ' ' . $attr1 . '="' . $value1 . '" ' . $attr2 . '="' . $value2 . '">', $markup->generateElement($element, [$attr1 => $value1, $attr2 => $value2], false), 'Markup::generateElement() should generate HTML tag with attributes.');
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function shortTagWithEscapeAttributes()
    {
        $element = 'script';
        $markup = new Markup($this->templating);

        $this->assertEquals('<' . $element . ' f&lt;oo="b&gt;ar">', $markup->generateElement($element, ['f<oo' => 'b>ar'], false), 'Markup::generateElement() should escape attributes names and values.');
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function shortXhtmlTag()
    {
        $element = 'script';
        $markup = new Markup($this->templating);

        $this->assertEquals('<' . $element . '/>', $markup->generateElement($element, [], true), 'Markup::generateElement() should generate self-closing tag for XHTML mode.');
    }
}
