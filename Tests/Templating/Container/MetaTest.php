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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Container;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Meta;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

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
class MetaTest extends PHPUnit_Framework_TestCase
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
     * Markup generator.
     *
     * @var Markup
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $markup;

    /**
     * @version 0.1.0
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
        $this->checker = new Checker();
        $this->markup = new Markup($this->templating);
    }

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
