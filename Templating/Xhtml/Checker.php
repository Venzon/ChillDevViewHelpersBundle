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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;

/**
 * Proxy for checking if site is using XHTML.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Checker
{
    /**
     * XHTML event listener.
     *
     * @var XhtmlResponseListener
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $listener;

    /**
     * Initializes proxy for given listener (if it exists).
     *
     * @param XhtmlResponseListener $listener XHTML event listener.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function __construct(XhtmlResponseListener $listener = null)
    {
        $this->listener = $listener;
    }

    /**
     * Checks if page uses XHTML.
     *
     * @return bool XHTML flag state.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function isXhtml()
    {
        return isset($this->listener) && $this->listener->getXhtml();
    }
}
