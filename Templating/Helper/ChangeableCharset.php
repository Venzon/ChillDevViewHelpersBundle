<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

/**
 * Base routines for helper charset changing.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
trait ChangeableCharset
{
    /**
     * Current context charset.
     *
     * @var string
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $charset = 'utf-8';

    /**
     * Sets current charset
     *
     * @param string $charset The charset.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Returns current charset.
     *
     * @return string The charset.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getCharset()
    {
        return $this->charset;
    }
}
