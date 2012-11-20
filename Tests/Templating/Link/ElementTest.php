<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Link;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Link\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ElementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpEngine
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $templating;

    /**
     * @var Checker
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $checker;

    /**
     * @version 0.0.2
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
        $this->checker = new Checker();
    }

    /**
     * Check if constructor arguments are remembered.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function parametersFromConstructor()
    {
        $href = 'foo';
        $rels = ['bar'];
        $type = 'baz';
        $media = 'qux';

        $element = new Element($this->templating, $this->checker, $href, $rels, $type, $media);

        $this->assertEquals($href, $element->getHref(), 'Element::__construct() should set href passed as argument.');
        $this->assertEquals($rels, $element->getRels(), 'Element::__construct() should set rels passed as argument.');
        $this->assertEquals($type, $element->getType(), 'Element::__construct() should set type passed as argument.');
        $this->assertEquals($media, $element->getMedia(), 'Element::__construct() should set media passed as argument.');
    }

    /**
     * Check if constructor sets default values for optional arguments.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function optionalConstructorParameters()
    {
        $element = new Element($this->templating, $this->checker, 'foo', ['bar']);

        $this->assertNull($element->getType(), 'Element::__construct() should set type to NULL if not passed as argument.');
        $this->assertNull($element->getMedia(), 'Element::__construct() should set media to NULL if not passed as argument.');
    }

    /**
     * Check if element can find rels.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function findingRel()
    {
        $value = 'foo';

        $element = new Element($this->templating, $this->checker, 'bar', ['baz', $value]);

        $this->assertTrue($element->hasRel($value), 'Element::hasRel() should find rel which is set on element.');
        $this->assertFalse($element->hasRel('qux'), 'Element::hasRel() should not find rel which is not set on element.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function toStringConversion()
    {
        $value1 = 'foo';
        $value2 = 'bar';
        $value3 = 'baz';
        $value4 = 'qux';

        $element = new Element($this->templating, $this->checker, $value1, [$value2], $value3, $value4);
        $this->assertEquals('<link href="' . $value1 . '" rel="' . $value2 . '" type="' . $value3 . '" media="' . $value4 . '">', $element->__toString(), 'Element::__toString() should generate <link> element snippet.');
    }

    /**
     * Check escaping.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function toStringEscape()
    {
        $value2 = 'bar';

        $element = new Element($this->templating, $this->checker, '&', [$value2]);
        $this->assertEquals('<link href="&amp;" rel="' . $value2 . '">', $element->__toString(), 'Element::__toString() should escape attribute values.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function toStringCasting()
    {
        $value1 = 'foo';
        $value2 = 'bar';
        $value3 = 'baz';

        $element = new Element($this->templating, $this->checker, $value1, [$value2, $value3]);
        $this->assertEquals('<link href="' . $value1 . '" rel="' . $value2 . ' ' . $value3 . '">', (string) $element, 'Element::__toString() should handle conversion to string.');
    }

    /**
     * Check rendering XHTML output.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function toStringXhtml()
    {
        $value1 = 'foo';
        $value2 = 'bar';

        $checker = new Checker((new XhtmlResponseListener())->setXhtml(true));

        $element = new Element($this->templating, $checker, $value1, [$value2]);
        $this->assertEquals('<link href="' . $value1 . '" rel="' . $value2 . '"/>', $element->__toString(), 'Element::__toString() should generate XHTML tag ending when XHTML is enabled.');
    }
}
