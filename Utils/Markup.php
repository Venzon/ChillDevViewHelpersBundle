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

namespace ChillDev\Bundle\ViewHelpersBundle\Utils;

use Symfony\Component\Templating\PhpEngine;

/**
 * Markup generator helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Markup
{
    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $templating;

    /**
     * Initializes markup generator.
     *
     * @param PhpEngine $templating Templating engine.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function __construct(PhpEngine $templating)
    {
        $this->templating = $templating;
    }

    /**
     * Generate short-tag HTML snippet.
     *
     * @param string $tag Tag name.
     * @param array $data Attributes map.
     * @param bool $isXhtml XHTML flag.
     * @return string (X)HTML snippet.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function generateElement($tag, array $data, $isXhtml)
    {
        // generate attributes
        $attrs = [];
        foreach ($data as $name => $content) {
            $attrs[] = ' ' . $this->templating->escape($name) . '="' . $this->templating->escape($content) . '"';
        }

        return '<' . $tag . \implode($attrs) . ($isXhtml ? '/>' : '>');
    }
}
