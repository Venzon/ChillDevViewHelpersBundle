<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Standalone;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class StandaloneTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $actions;

    /**
     * @version 0.1.3
     * @since 0.1.3
     */
    protected function setUp()
    {
        $this->actions = $this->getMock('Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\ActionsHelper', [], [], '', false);
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getHelperName()
    {
        $this->assertEquals('standalone', (new Standalone($this->actions))->getName(), 'Standalone::getName() should return helper alias.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function render()
    {
        $standalone = new Standalone($this->actions);

        $toReturn = new \stdClass();
        $controller = new \stdClass();

        $this->actions->expects($this->once())
            ->method('controller')
            ->with($this->identicalTo($controller), $this->anything(), $this->anything());

        $this->actions->expects($this->once())
            ->method('render')
            ->with($this->anything(), $this->anything())
            ->will($this->returnValue($toReturn));

        $this->assertSame($toReturn, $standalone->render($controller), 'Standalone::render() should render reference to given controller.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function renderStrategy()
    {
        $standalone = new Standalone($this->actions);

        $toReturn = new \stdClass();
        $options = ['strategy' => 'esi'];

        $this->actions->expects($this->once())
            ->method('render')
            ->with($this->anything(), $this->equalTo($options))
            ->will($this->returnValue($toReturn));

        $this->assertSame($toReturn, $standalone->render('foo', $options['strategy']), 'Standalone::render() should render reference to given controller.');
    }
}
