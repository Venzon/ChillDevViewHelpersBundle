<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Link;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Link\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class LinkTest extends PHPUnit_Framework_TestCase
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
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function getHelperName()
    {
        $this->assertEquals('link', (new Link($this->templating, $this->checker))->getName(), 'Link::getName() should return helper alias.');
    }

    /**
     * Check if element is added to container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function addToContainer()
    {
        $href = 'foo';
        $rels = ['bar'];
        $type = 'baz';
        $media = 'qux';

        $link = new Link($this->templating, $this->checker);
        $return = $link->add($href, $rels, $type, $media);

        $element = $link->getByRel($rels[0])[0];

        $this->assertEquals($href, $element->getHref(), 'Link::add() should set href passed as argument.');
        $this->assertEquals($rels, $element->getRels(), 'Link::add() should set rels passed as argument.');
        $this->assertEquals($type, $element->getType(), 'Link::add() should set type passed as argument.');
        $this->assertEquals($media, $element->getMedia(), 'Link::add() should set media passed as argument.');
        $this->assertSame($link, $return, 'Link::add() should return reference to itself.');
    }

    /**
     * Check default attributes values.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function addWithDefaultValues()
    {
        $rel = 'foo';

        $link = new Link($this->templating, $this->checker);
        $link->add('bar', [$rel]);

        $this->assertNull($link->getByRel($rel)[0]->getType(), 'Link::add() should set type to NULL if not passed as argument.');
        $this->assertNull($link->getByRel($rel)[0]->getMedia(), 'Link::add() should set media to NULL if not passed as argument.');
    }

    /**
     * Check if stylesheet is added to container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheetToContainer()
    {
        $href = 'foo';
        $rel = Link::REL_STYLESHEET;
        $type = 'baz';
        $media = 'qux';

        $link = new Link($this->templating, $this->checker);
        $return = $link->addStylesheet($href, $media, $type);

        $element = $link->getByRel($rel)[0];

        $this->assertEquals($href, $element->getHref(), 'Link::addStylesheet() should set href passed as argument.');
        $this->assertEquals($type, $element->getType(), 'Link::addStylesheet() should set type passed as argument.');
        $this->assertEquals($media, $element->getMedia(), 'Link::addStylesheet() should set media passed as argument.');
        $this->assertEquals([$rel], $element->getRels(), 'Link::addStylesheet() should set rel to Link::REL_STYLESHEET.');
        $this->assertSame($link, $return, 'Link::addStylesheet() should return reference to itself.');
    }

    /**
     * Check default attributes values for stylesheet.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheetWithDefaultValues()
    {
        $link = new Link($this->templating, $this->checker);
        $link->addStylesheet('bar');

        $this->assertEquals("text/css", $link->getByRel(Link::REL_STYLESHEET)[0]->getType(), 'Link::addStylesheet() should set type to "text/css" if not passed as argument.');
        $this->assertNull($link->getByRel(Link::REL_STYLESHEET)[0]->getMedia(), 'Link::addStylesheet() should set media to NULL if not passed as argument.');
    }

    /**
     * Check if multiple stylesheets are added to container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheetsToContainer()
    {
        $href1 = 'foo';
        $href2 = 'bar';
        $rel = Link::REL_STYLESHEET;
        $type = 'baz';
        $media = 'qux';

        $link = new Link($this->templating, $this->checker);
        $return = $link->addStylesheets([$href1, $href2], $media, $type);

        $elements = $link->getByRel($rel);

        $this->assertEquals($href1, $elements[0]->getHref(), 'Link::addStylesheets() should set href from list passed as argument.');
        $this->assertEquals($type, $elements[0]->getType(), 'Link::addStylesheets() should set type passed as argument.');
        $this->assertEquals($media, $elements[0]->getMedia(), 'Link::addStylesheets() should set media passed as argument.');
        $this->assertEquals([$rel], $elements[0]->getRels(), 'Link::addStylesheets() should set rel to Link::REL_STYLESHEET.');
        $this->assertEquals($href2, $elements[1]->getHref(), 'Link::addStylesheets() should set href from list passed as argument.');
        $this->assertEquals($type, $elements[1]->getType(), 'Link::addStylesheets() should set type passed as argument.');
        $this->assertEquals($media, $elements[1]->getMedia(), 'Link::addStylesheets() should set media passed as argument.');
        $this->assertEquals([$rel], $elements[1]->getRels(), 'Link::addStylesheets() should set rel to Link::REL_STYLESHEET.');
        $this->assertSame($link, $return, 'Link::addStylesheets() should return reference to itself.');
    }

    /**
     * Check default attributes values for batch-added stylesheets.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheetsWithDefaultValues()
    {
        $link = new Link($this->templating, $this->checker);
        $link->addStylesheets(['foo', 'bar']);

        $this->assertEquals("text/css", $link->getByRel(Link::REL_STYLESHEET)[0]->getType(), 'Link::addStylesheets() should set all types to "text/css" if not passed as argument.');
        $this->assertNull($link->getByRel(Link::REL_STYLESHEET)[0]->getMedia(), 'Link::addStylesheets() should set all media to NULL if not passed as argument.');
        $this->assertEquals("text/css", $link->getByRel(Link::REL_STYLESHEET)[1]->getType(), 'Link::addStylesheets() should set all types to "text/css" if not passed as argument.');
        $this->assertNull($link->getByRel(Link::REL_STYLESHEET)[1]->getMedia(), 'Link::addStylesheets() should set all media to NULL if not passed as argument.');
    }

    /**
     * Check string-to-array conversion of rel attribute.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function addWithStringAsRels()
    {
        $href = 'foo';
        $rel = 'bar';

        $link = new Link($this->templating, $this->checker);
        $link->add($href, $rel);

        $this->assertEquals($href, $link->getByRel($rel)[0]->getHref(), 'Link::add() should convert rel attribute to array if single string is specified.');
    }

    /**
     * Check finding elemnets by rel attribute.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function getByRelCounts()
    {
        $rel = 'foo';

        $link = new Link($this->templating, $this->checker);
        $link->add('bar', [$rel])
            ->add('bar', [$rel, 'baz'])
            ->add('bar', ['baz']);

        $this->assertCount(2, $link->getByRel($rel), 'Link::getByRel() should find all elements defined with given rel attribute.');
    }

    /**
     * Check deleting links from container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.1
     */
    public function deleteFromContainer()
    {
        $rel = 'foo';

        $link = new Link($this->templating, $this->checker);
        $link->add('bar', [$rel]);

        $this->assertCount(1, $link->getByRel($rel), 'If this fails, check add() or getByRel() test.');

        $elements = $link->getByRel($rel);
        $link->delete($elements[0]);

        $this->assertCount(0, $link->getByRel($rel), 'Link::delete() should delete element from container.');
    }

    /**
     * Check get/set charset.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function charsetChange()
    {
        $charset = 'iso-8859-2';

        $title = new Link($this->templating, $this->checker);
        $title->setCharset($charset);
        $this->assertEquals($charset, $title->getCharset(), 'Link::setCharset() should change used charset.');
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

        $element1 = new Element($this->templating, $this->checker, $value1, [$value2, $value3]);
        $element2 = new Element($this->templating, $this->checker, $value1, [$value2, $value3]);

        $link = new Link($this->templating, $this->checker);
        $link->add($value1, [$value2, $value3])
            ->add($value1, [$value2, $value3]);

        $this->assertEquals(((string) $element1) . ((string) $element2), $link->__toString(), 'Link::__toString() should generate all contained <link> tags.');
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

        $link = new Link($this->templating, $this->checker);
        $link->add($value1, [$value2, $value3]);

        $this->assertEquals((string) $element, (string) $link, 'Link::__toString() should handle conversion to string.');
    }
}
