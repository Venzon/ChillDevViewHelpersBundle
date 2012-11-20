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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Xhtml;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class CheckerTest extends PHPUnit_Framework_TestCase
{
    /**
     * XHTML filter.
     *
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
     * Check default checker status.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function disabledXhtml()
    {
        $checker = new Checker();
        $this->assertFalse($checker->isXhtml(), 'Checker should report disabled XHTML when no XHTML event listener is provided.');
    }

    /**
     * Check checker status when XHTML is forced to true.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function xhtmlSetToTrue()
    {
        $checker = new Checker($this->listener);
        $this->listener->setXhtml(true);

        $this->assertTrue($checker->isXhtml(), 'Checker should report enabled XHTML when XHTML event listener has enabled XHTML.');
    }

    /**
     * Check checker status when XHTML is forced to false.
     *
     * @test
     * @version 0.0.2
     * @since 0.0.2
     */
    public function xhtmlSetToFalse()
    {
        $checker = new Checker($this->listener);
        $this->listener->setXhtml(false);

        $this->assertFalse($checker->isXhtml(), 'Checker should report disabled XHTML when XHTML event listener has disabled XHTML.');
    }
}
