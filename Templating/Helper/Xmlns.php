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

use ArrayObject;
use OutOfBoundsException;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\HelperInterface;

/**
 * xmlns attribute helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.1.0
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Xmlns extends ArrayObject implements
    HelperInterface
{
    use ChangeableCharset;

    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $templating;

    /**
     * Initializes templating helper.
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
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getName()
    {
        return 'xmlns';
    }

    /**
     * Generates XML prefix for given registered namespace.
     *
     * @param string $namespace XML namespace registered in helper.
     * @return string XML prefix.
     * @throws OutOfBoundsException When given namespace is not registered.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function getPrefix($namespace)
    {
        if (!isset($this[$namespace])) {
            throw new OutOfBoundsException(\sprintf('XML namespace "%s" is not registered.', $namespace));
        }

        // default namespace doesn't need any prefix
        return empty($this[$namespace]) ? '' : $this[$namespace] . ':';
    }

    /**
     * Generates string representation.
     *
     * @return string Text representation.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function __toString()
    {
        $attributes = [];

        // generate all xmlns="" attributes
        foreach ($this as $namespace => $prefix) {
            $attributes[] = ' xmlns' .
                (empty($prefix) ? '' : ':' . $this->templating->escape($prefix))
                . '="' . $this->templating->escape($namespace) . '"';
        }

        return \implode($attributes);
    }
}
