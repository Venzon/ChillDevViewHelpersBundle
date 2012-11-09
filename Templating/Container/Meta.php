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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Container;

use ArrayObject;

use Symfony\Component\Templating\PhpEngine;

/**
 * Meta-values container.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Meta extends ArrayObject
{
    /**
     * Identifying attribute.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $attribute;

    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $templating;

    /**
     * Initializes container.
     *
     * @param PhpEngine $templating Templating engine.
     * @param string $attribute Attribute used by this container.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating, $attribute)
    {
        parent::__construct();

        $this->templating = $templating;
        $this->attribute = $attribute;
    }

    /**
     * Returns attribute name.
     *
     * @return string Attribute name for <meta> element.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Generates string representation.
     *
     * @return string Text representation.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __toString()
    {
        $tags = [];

        // generate <meta> tags
        foreach ($this as $key => $value) {
            $tags[] = '<meta '
                . $this->attribute . '="' . $this->templating->escape($key)
                . '" content="' . $this->templating->escape($value) . '"/>';
        }

        return \implode($tags);
    }
}
