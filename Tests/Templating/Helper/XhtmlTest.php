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

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Xhtml;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class XhtmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var XhtmlResponseListener
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $listener;

    /**
     * @version 0.0.1
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->listener = new XhtmlResponseListener();
    }

    /**
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getHelperName()
    {
        $this->assertEquals('xhtml', (new Xhtml($this->listener))->getName(), 'Xhtml::getName() should return helper alias.');
    }

    /**
     * Check default value of XHTML switch call.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultXhtmlSwitch()
    {
        $xhtml = new Xhtml($this->listener);
        $return = $xhtml->setXhtml();

        $this->assertTrue($this->listener->getXhtml(), 'Xhtml::setXhtml() should enable XHTML by default.');
        $this->assertSame($xhtml, $return, 'Xhtml::setXhtml() should return reference to itself.');
    }

    /**
     * Check passing value of XHTML switch call.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setXhtmlSwitch()
    {
        (new Xhtml($this->listener))->setXhtml(false);
        $this->assertFalse($this->listener->getXhtml(), 'Xhtml::setXhtml() should pass specified XHTML switch.');
    }

    /**
     * Check default value of direct invoking call.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultInvokeSwitch()
    {
        $xhtml = new Xhtml($this->listener);
        $return = $xhtml->__invoke();

        $this->assertTrue($this->listener->getXhtml(), 'Xhtml::__invoke() should enable XHTML by default.');
        $this->assertSame($xhtml, $return, 'Xhtml::__invoke() should return reference to itself.');
    }

    /**
     * Check passing value of direct invoking call.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setInvokeSwitch()
    {
        (new Xhtml($this->listener))->__invoke(false);
        $this->assertFalse($this->listener->getXhtml(), 'Xhtml::__invoke() should pass specified XHTML switch.');
    }

    /**
     * Check handling of inline invoking.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function callableInvoke()
    {
        $xhtml = new Xhtml($this->listener);
        $xhtml(false);
        $this->assertFalse($this->listener->getXhtml(), 'Xhtml::__invoke() should handle inline invocation of object as function.');
    }
}
