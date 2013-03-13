<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafa³ Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafa³ Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Paginator;
use ChillDev\Bundle\ViewHelpersBundle\Tests\BaseTemplatingTest;

/**
 * @author Rafa³ Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafa³ Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class PaginatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $router;

    /**
     * @var Symfony\Component\Translation\TranslatorInterface
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $translator;

    /**
     * @var Symfony\Component\Templating\PhpEngine
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $templating;

    /**
     * @var Paginator
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $paginator;

    /**
     * @version 0.1.3
     * @since 0.1.3
     */
    protected function setUp()
    {
        $this->router = $this->getMock('Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper', [], [], '', false);
        $this->translator = $this->getMock('Symfony\\Component\\Translation\\TranslatorInterface');
        $this->templating = $this->getMock('Symfony\\Component\\Templating\\PhpEngine', [], [], '', false);
        $this->paginator = new Paginator($this->router, $this->translator, $this->templating);
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getHelperName()
    {
        $this->assertEquals('paginator', $this->paginator->getName(), 'Paginator::getName() should return helper alias.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function renderDefaultTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->once())
            ->method('getTemplate')
            ->will($this->returnValue($toReturn));

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->render($paginator), 'Paginator::render() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function renderCustomTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->never())
            ->method('getTemplate');

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->render($paginator, $toReturn), 'Paginator::render() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function sortableDefaultTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->once())
            ->method('getSortableTemplate')
            ->will($this->returnValue($toReturn));

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->sortable($paginator, 'foo', 'bar'), 'Paginator::sortable() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function sortableCustomTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->never())
            ->method('getSortableTemplate');

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->sortable($paginator, 'foo', 'bar', [], [], $toReturn), 'Paginator::sortable() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function sortableOptions1()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->once())
            ->method('getSortableTemplate')
            ->will($this->returnValue($toReturn));

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $paginator->expects($this->once())
            ->method('isSorted')
            ->with($this->anything(), $this->anything())
            ->will($this->returnValue(true));

        $this->assertSame($result, $this->paginator->sortable($paginator, ['asc'], 'bar', ['translationDomain' => true], [null => 'asc']), 'Paginator::sortable() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function sortableOptions2()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->once())
            ->method('getSortableTemplate')
            ->will($this->returnValue($toReturn));

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $paginator->expects($this->once())
            ->method('isSorted')
            ->with($this->anything(), $this->anything())
            ->will($this->returnValue(true));

        $this->assertSame($result, $this->paginator->sortable($paginator, ['desc' => 'foo'], 'bar', ['translationDomain' => true, 'translationCount' => true, 'class' => 'baz'], [null => 'asc']), 'Paginator::sortable() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function filterDefaultTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->once())
            ->method('getFiltrationTemplate')
            ->will($this->returnValue($toReturn));

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->filter($paginator, ['foo']), 'Paginator::filter() should return rendered template.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function filterCustomTemplate()
    {
        $paginator = $this->getPginatorMock();

        $toReturn = new \stdClass();
        $result = new \stdClass();

        $paginator->expects($this->never())
            ->method('getFiltrationTemplate');

        $this->templating->expects($this->once())
            ->method('render')
            ->with($this->identicalTo($toReturn), $this->anything())
            ->will($this->returnValue($result));

        $this->assertSame($result, $this->paginator->filter($paginator, ['foo'], [], [], $toReturn), 'Paginator::filter() should return rendered template.');
    }

    /**
     * @return Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     * @version 0.1.3
     * @since 0.1.3
     */
    protected function getPginatorMock()
    {
        $paginator = $this->getMock('Knp\\Bundle\\PaginatorBundle\\Pagination\\SlidingPagination', [], [], '', false);

        $paginator->expects($this->once())
            ->method('getParams')
            ->will($this->returnValue([]));

        $paginator->expects($this->once())
            ->method('getPaginatorOptions')
            ->will($this->returnValue([]));

        $paginator->expects($this->once())
            ->method('getCustomParameters')
            ->will($this->returnValue([]));

        return $paginator;
    }
}