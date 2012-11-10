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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use ChillDev\Bundle\ViewHelpersBundle\EventListener\XhtmlResponseListener;

use Symfony\Component\Templating\Helper\Helper;

/**
 * XHTML Content-Type switch helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Xhtml extends Helper
{
    /**
     * XHTML response filter.
     *
     * @var XhtmlResponseListener
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $filter;

    /**
     * Initializes helper for given filter.
     *
     * @param XhtmlResponseListener $filter Response filter.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(XhtmlResponseListener $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getName()
    {
        return 'xhtml';
    }

    /**
     * Changes XHTML flag.
     *
     * @param bool $flag XHTML switch.
     * @return self Self reference.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setXhtml($flag = true)
    {
        $this->filter->setXhtml($flag);

        return $this;
    }

    /**
     * Shorter way for invoking helper method.
     *
     * @param bool $flag XHTML switch.
     * @return self Self reference.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __invoke($flag = true)
    {
        return $this->setXhtml($flag);
    }
}
