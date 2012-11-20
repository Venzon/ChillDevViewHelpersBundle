<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Real XHTML Content-Type filter.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class XhtmlResponseListener
{
    /**
     * XHTML flag.
     *
     * @var bool
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $xhtml = false;

    /**
     * Sets XHTML flag.
     *
     * @param bool $xhtml New flag value.
     * @reutrn self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setXhtml($xhtml = true)
    {
        $this->xhtml = $xhtml;

        return $this;
    }

    /**
     * Returns XHTML flag.
     *
     * @return bool XHTML flag state.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getXhtml()
    {
        return $this->xhtml;
    }

    /**
     * Handles Content-Type switch for HTML format.
     *
     * @param FilterResponseEvent $event Response event.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ($this->xhtml
            && HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()
            // only do something when the requested format is "html"
            && $request->getRequestFormat() == 'html'
            // make sure client supports XHTML MIME-Type
            && \in_array('application/xhtml+xml', $request->getAcceptableContentTypes())
        ) {
            $response->headers->set(
                'Content-Type',
                'application/xhtml+xml; charset=' . ($response->getCharset() ?: 'utf-8')
            );
        }
    }
}
