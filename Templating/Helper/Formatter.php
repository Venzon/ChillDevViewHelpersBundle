<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use Sonata\FormatterBundle\Formatter\Pool;

use Symfony\Component\Templating\Helper\Helper;

/**
 * Formatter helper.
 *
 * This is PHP helper, since SonataFormatterBundle provides only one for Twig.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Formatter extends Helper
{
    /**
     * Formatter.
     *
     * @var Pool
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $formatter;

    /**
     * Initializes object.
     *
     * @param Pool $formatter Formatter service.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function __construct(Pool $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Performs text formatting.
     *
     * @param string $format Input format.
     * @param string $text Source text.
     * @return string Formatted text.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function transform($format, $text)
    {
        return $this->formatter->transform($format, $text);
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getName()
    {
        return 'formatter';
    }
}
