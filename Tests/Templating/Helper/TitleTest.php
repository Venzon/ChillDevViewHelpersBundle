<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Title;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class TitleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpEngine
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $templating;

    /**
     * @version 0.0.1
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
    }

    /**
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getHelperName()
    {
        $this->assertEquals('title', (new Title($this->templating))->getName(), 'Title::getName() should return helper alias.');
    }

    /**
     * Check if separator passed to constructor is remembered.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function separatorFromConstructor()
    {
        $separator = '!';

        $title = new Title($this->templating, $separator);
        $this->assertEquals($separator, $title->getSeparator(), 'Title::__construct() should set separator passed as argument.');
    }

    /**
     * Check get/set charset.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function charsetChange()
    {
        $charset = 'iso-8859-2';

        $title = new Title($this->templating);
        $title->setCharset($charset);
        $this->assertEquals($charset, $title->getCharset(), 'Title::setCharset() should change used charset.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function toStringConversion()
    {
        $separator = '!';
        $value1 = 'foo';
        $value2 = 'bar';

        $title = new Title($this->templating, $separator);
        $title->append($value1, $value2);
        $this->assertEquals('<title>' . $value1 . $separator . $value2 . '</title>', $title->__toString(), 'Title::__toString() should generate <title> tag by concating all elements glued with separator.');
    }

    /**
     * Check escaping.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function toStringEscape()
    {
        $title = new Title($this->templating);
        $title->append('&');
        $this->assertEquals('<title>&amp;</title>', $title->__toString(), 'Title::__toString() should escape title content.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function toStringCasting()
    {
        $separator = '!';
        $value1 = 'foo';
        $value2 = 'bar';

        $title = new Title($this->templating, $separator);
        $title->append($value1, $value2);
        $this->assertEquals('<title>' . $value1 . $separator . $value2 . '</title>', (string) $title, 'Title::__toString() should handle conversion to string.');
    }
}
