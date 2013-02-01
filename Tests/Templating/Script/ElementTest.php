<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Script;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Tests\BaseTemplatingTest;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ElementTest extends BaseTemplatingTest
{
    /**
     * Check if constructor arguments are remembered.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function parametersFromConstructor()
    {
        $src = 'foo';
        $flow = Element::FLOW_ASYNC;
        $type = 'baz';
        $charset = 'qux';

        $element = new Element($this->templating, $this->checker, $this->markup, $src, $type, $flow, $charset);

        $this->assertEquals($src, $element->getSrc(), 'Element::__construct() should set src passed as argument.');
        $this->assertEquals($flow, $element->getFlow(), 'Element::__construct() should set flow passed as argument.');
        $this->assertEquals($type, $element->getType(), 'Element::__construct() should set type passed as argument.');
        $this->assertEquals($charset, $element->getCharset(), 'Element::__construct() should set charset passed as argument.');
    }

    /**
     * Check if constructor sets default values for optional arguments.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function optionalConstructorParameters()
    {
        $element = new Element($this->templating, $this->checker, $this->markup, 'foo');

        $this->assertEquals(Element::TYPE_TEXTJAVASCRIPT, $element->getType(), 'Element::__construct() should set type to Element::TYPE_TEXTJAVASCRIPT if not passed as argument.');
        $this->assertEquals(Element::FLOW_DEFAULT, $element->getFlow(), 'Element::__construct() should set flow to Element::FLOW_DEFAULT if not passed as argument.');
        $this->assertNull($element->getCharset(), 'Element::__construct() should set charset to NULL if not passed as argument.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function toStringConversion()
    {
        $value1 = 'foo';
        $value2 = 'bar';
        $value3 = 'baz';

        $element = new Element($this->templating, $this->checker, $this->markup, $value1, $value2, Element::FLOW_DEFAULT, $value3);
        $this->assertEquals('<script src="' . $value1 . '" type="' . $value2 . '" charset="' . $value3 . '"></script>', $element->__toString(), 'Element::__toString() should generate <script> element snippet.');
    }

    /**
     * Check to-string conversion with defer="defer" attribute.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function toStringConversionWithDefer()
    {
        $value1 = 'foo';
        $value2 = 'bar';

        $element = new Element($this->templating, $this->checker, $this->markup, $value1, $value2, Element::FLOW_DEFER);
        $this->assertEquals('<script src="' . $value1 . '" type="' . $value2 . '" defer="defer"></script>', $element->__toString(), 'Element::__toString() should generate defer="defer" attribute when Element::FLOW_DEFER is used.');
    }

    /**
     * Check to-string conversion with async="async" attribute.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function toStringConversionWithAsync()
    {
        $value1 = 'foo';
        $value2 = 'bar';

        $element = new Element($this->templating, $this->checker, $this->markup, $value1, $value2, Element::FLOW_ASYNC);
        $this->assertEquals('<script src="' . $value1 . '" type="' . $value2 . '" async="async"></script>', $element->__toString(), 'Element::__toString() should generate async="async" attribute when Element::FLOW_ASYNC is used.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function toStringCasting()
    {
        $value1 = 'foo';

        $element = new Element($this->templating, $this->checker, $this->markup, $value1, null);
        $this->assertEquals('<script src="' . $value1 . '"></script>', (string) $element, 'Element::__toString() should handle conversion to string.');
    }

    /**
     * Check rendering XHTML output.
     *
     * @test
     * @version 0.1.0
     * @since 0.0.2
     */
    public function toStringXhtml()
    {
        $value1 = 'foo';

        $checker = new Checker((new XhtmlResponseListener())->setXhtml(true));

        $element = new Element($this->templating, $checker, $this->markup, $value1, null);
        $this->assertEquals('<script src="' . $value1 . '"/>', $element->__toString(), 'Element::__toString() should generate XHTML tag ending when XHTML is enabled.');
    }
}
