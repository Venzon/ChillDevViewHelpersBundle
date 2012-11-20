<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Script;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ScriptTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpEngine
     * @version 0.0.2
     * @since 0.0.2
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
     * @since 0.0.2
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
        $this->checker = new Checker();
    }

    /**
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getHelperName()
    {
        $this->assertEquals('script', (new Script($this->templating, $this->checker))->getName(), 'Script::getName() should return helper alias.');
    }

    /**
     * Check if element is added to container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addToContainer()
    {
        $src = 'foo';
        $type = 'bar';
        $flow = Element::FLOW_ASYNC;
        $charset = 'baz';

        $script = new Script($this->templating, $this->checker);
        $return = $script->add($src, $type, $flow, $charset);

        $element = new Element($this->templating, $this->checker, $src, $type, $flow, $charset);

        $this->assertEquals($element->__toString(), $script->__toString(), 'Script::add() should set src, type, async/defer and charset attributes passed as arguments.');
        $this->assertSame($script, $return, 'Script::add() should return reference to itself.');
    }

    /**
     * Check default attributes values.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addWithDefaultValues()
    {
        $src = 'foo';

        $script = new Script($this->templating, $this->checker);
        $script->add($src);

        $element = new Element($this->templating, $this->checker, $src, Element::TYPE_TEXTJAVASCRIPT);

        $this->assertEquals($element->__toString(), $script->__toString(), 'Script::add() should set type to Element::TYPE_TEXTJAVASCRIPT, execution flow to Element::FLOW_DEFAULT and charset to none by default.');
    }

    /**
     * Check if multiple scripts are added to container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addManyToContainer()
    {
        $src1 = 'foo';
        $src2 = 'bar';
        $type = 'baz';
        $flow = Element::FLOW_ASYNC;
        $charset = 'quz';

        $script = new Script($this->templating, $this->checker);
        $script->add($src1, $type, $flow, $charset)
            ->add($src2, $type, $flow, $charset);

        $element1 = new Element($this->templating, $this->checker, $src1, $type, $flow, $charset);
        $element2 = new Element($this->templating, $this->checker, $src2, $type, $flow, $charset);

        $this->assertEquals($element1->__toString() . $element2->__toString(), $script->__toString(), 'Script::addMany() should set type, async/defer and charset attributes passed as arguments and add element for each of src passed in list.');
    }

    /**
     * Check default attributes values for batch-added scripts.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addManyWithDefaultValues()
    {
        $src1 = 'foo';
        $src2 = 'bar';

        $script = new Script($this->templating, $this->checker);
        $script->add($src1)
            ->add($src2);

        $element1 = new Element($this->templating, $this->checker, $src1, Element::TYPE_TEXTJAVASCRIPT);
        $element2 = new Element($this->templating, $this->checker, $src2, Element::TYPE_TEXTJAVASCRIPT);

        $this->assertEquals($element1->__toString() . $element2->__toString(), $script->__toString(), 'Script::addMany() should set type to Element::TYPE_TEXTJAVASCRIPT, execution flow to Element::FLOW_DEFAULT and charset to none by default.');
    }

    /**
     * Check deleting scripts from container.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function deleteFromContainer()
    {
        $src = 'foo';

        $script = new Script($this->templating, $this->checker);
        $script->add($src);

        $script->delete($src);

        $this->assertEmpty($script->__toString(), 'Script::delete() should delete element with given src from container.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function toStringConversion()
    {
        $value1 = 'foo';

        $element1 = new Element($this->templating, $this->checker, $value1, Element::TYPE_TEXTJAVASCRIPT);
        $element2 = new Element($this->templating, $this->checker, $value1, Element::TYPE_TEXTJAVASCRIPT);

        $script = new Script($this->templating, $this->checker);
        $script->add($value1)
            ->add($value1);

        $this->assertEquals(((string) $element1) . ((string) $element2), $script->__toString(), 'Script::__toString() should generate all contained <script> tags.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function toStringCasting()
    {
        $value1 = 'foo';

        $element = new Element($this->templating, $this->checker, $value1, Element::TYPE_TEXTJAVASCRIPT);

        $script = new Script($this->templating, $this->checker);
        $script->add($value1);

        $this->assertEquals((string) $element, (string) $script, 'Script::__toString() should handle conversion to string.');
    }
}
