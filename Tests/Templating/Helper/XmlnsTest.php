<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Xmlns;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class XmlnsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpEngine
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $templating;

    /**
     * @version 0.1.0
     * @since 0.1.0
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getHelperName()
    {
        $this->assertEquals('xmlns', (new Xmlns($this->templating))->getName(), 'Xmlns::getName() should return helper alias.');
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

        $xmlns = new Xmlns($this->templating);
        $xmlns->setCharset($charset);
        $this->assertEquals($charset, $xmlns->getCharset(), 'Xmlns::setCharset() should change used charset.');
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getDefaultPrefix()
    {
        $namespace = 'foo';

        $xmlns = new Xmlns($this->templating);
        $xmlns[$namespace] = '';
        $this->assertEquals('', $xmlns->getPrefix($namespace), 'Xmlns::getPrefix() should generate empty prefix for default namespace.');
    }

    /**
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getDefinedPrefix()
    {
        $namespace = 'foo';
        $alias = 'bar';

        $xmlns = new Xmlns($this->templating);
        $xmlns[$namespace] = $alias;
        $this->assertEquals($alias . ':', $xmlns->getPrefix($namespace), 'Xmlns::getPrefix() should generate prefix for defined namespace.');
    }

    /**
     * @test
     * @expectedException OutOfBoundsException
     * @expectedExceptionMessage XML namespace "foo" is not registered.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getUnexistingPrefix()
    {
        $xmlns = new Xmlns($this->templating);
        $xmlns->getPrefix('foo');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function toStringConversion()
    {
        $namespace = 'foo';
        $alias = 'bar';

        $xmlns = new Xmlns($this->templating);
        $xmlns[$namespace] = $alias;
        $this->assertEquals(' xmlns:' . $alias . '="' . $namespace . '"', $xmlns->__toString(), 'Xmlns::__toString() should generate xmlns="" attribute with prefix alias and namespace reference.');
    }

    /**
     * Check escaping.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function toStringEscape()
    {
        $xmlns = new Xmlns($this->templating);
        $xmlns['&'] = '<';
        $this->assertEquals(' xmlns:&lt;="&amp;"', $xmlns->__toString(), 'Xmlns::__toString() should escape namespace and prefix.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function toStringCasting()
    {
        $namespace = 'foo';
        $alias = 'bar';

        $xmlns = new Xmlns($this->templating);
        $xmlns[$namespace] = $alias;
        $this->assertEquals(' xmlns:' . $alias . '="' . $namespace . '"', (string) $xmlns, 'Xmlns::__toString() should handle conversion to string.');
    }
}
