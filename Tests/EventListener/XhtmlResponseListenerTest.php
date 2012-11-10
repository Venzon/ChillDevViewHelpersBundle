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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\EventListener;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class XhtmlResponseListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    const TEXT_HTML = 'text/html';

    /**
     * @var MockKernel
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $mock;

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
        $this->mock = new MockKernel();
        $this->listener = new XhtmlResponseListener();
    }

    /**
     * Check handling with default flag.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultFlag()
    {
        $request = Request::create('/');
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $this->listener->onKernelResponse($event);

        $this->assertEquals(self::TEXT_HTML, $response->headers->get('Content-Type'), 'XHTML content type switch should be disabled by default.');
    }

    /**
     * Check handling with flag set to default parameter value.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultParameter()
    {
        $charset = 'iso-8859-2';

        $request = Request::create('/');
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $response->setCharset($charset);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $return = $this->listener->setXhtml();
        $this->listener->onKernelResponse($event);

        $this->assertEquals('application/xhtml+xml; charset=' . $charset, $response->headers->get('Content-Type'), 'XhtmlResponseListener::setXhtml() should set flag to true by default and XhtmlResponseListener::onKernelResponse() should set XHTML content type if request supports it.');
        $this->assertSame($this->listener, $return, 'XhtmlResponseListener::setXhtml() should return reference to itself.');
    }

    /**
     * Check setting default charset when response has none specified.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultCharset()
    {
        $request = Request::create('/');
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $this->listener->setXhtml()
            ->onKernelResponse($event);

        $this->assertEquals('application/xhtml+xml; charset=utf-8', $response->headers->get('Content-Type'), 'XhtmlResponseListener::onKernelResponse() should set UTF-8 as default charset.');
    }

    /**
     * Check handling with flag set.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function flagSet()
    {
        $request = Request::create('/');
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $this->listener->setXhtml(false)
            ->onKernelResponse($event);

        //TODO: check with proper event with set flag explicitly to false

        $this->assertEquals(self::TEXT_HTML, $response->headers->get('Content-Type'), 'XhtmlResponseListener::setXhtml() should set flag to specified value.');
    }

    /**
     * Check non-master request handling.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function nonMasterRequest()
    {
        $request = Request::create('/');
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::SUB_REQUEST, $response);

        $this->listener->onKernelResponse($event);

        $this->assertEquals(self::TEXT_HTML, $response->headers->get('Content-Type'), 'XhtmlResponseListener::onKernelResponse() should not set XHTML Content-Type for non-master requests.');
    }

    /**
     * Check handling request of different format then HTML.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function nonHtmlRequest()
    {
        $request = Request::create('/', 'GET', ['_format' => 'json']);
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $this->listener->onKernelResponse($event);

        $this->assertEquals(self::TEXT_HTML, $response->headers->get('Content-Type'), 'XhtmlResponseListener::onKernelResponse() should not set XHTML Content-Type if request is not for (X)HTML content.');
    }

    /**
     * Check handling request which does not accept XHTML content type.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function xhtmlNotSupported()
    {
        $request = Request::create('/', 'GET', [], [], [], [
                'HTTP_ACCEPT' => self::TEXT_HTML,
        ]);
        $response = new Response('', 200, [
                'Content-Type' => self::TEXT_HTML,
        ]);
        $event = new FilterResponseEvent($this->mock, $request, HttpKernelInterface::MASTER_REQUEST, $response);

        $this->listener->onKernelResponse($event);

        $this->assertEquals(self::TEXT_HTML, $response->headers->get('Content-Type'), 'XhtmlResponseListener::onKernelResponse() should not set XHTML Content-Type if client does not accept such type.');
    }
}

class MockKernel implements HttpKernelInterface
{
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        // dummy
    }
}
