<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Container;

use ArrayObject;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

use Symfony\Component\Templating\PhpEngine;

/**
 * Meta-values container.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
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
     * XHTML checker.
     *
     * @var Checker
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $checker;

    /**
     * Markup generator.
     *
     * @var Markup
     * @version 0.1.0
     * @since 0.1.0
     */
    protected $markup;

    /**
     * Initializes container.
     *
     * @param PhpEngine $templating Templating engine.
     * @param Checker $checker XHTML checker.
     * @param Markup $markup Markup generator.
     * @param string $attribute Attribute used by this container.
     * @version 0.1.0
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating, Checker $checker, Markup $markup, $attribute)
    {
        parent::__construct();

        $this->templating = $templating;
        $this->checker = $checker;
        $this->markup = $markup;
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
     * @version 0.1.0
     * @since 0.0.1
     */
    public function __toString()
    {
        $tags = [];

        // generate <meta> tags
        foreach ($this as $key => $value) {
            $tags[] = $this->markup->generateElement(
                'meta',
                [
                    $this->attribute => $key,
                    'content' => $value,
                ],
                $this->checker->isXhtml()
            );
        }

        return \implode($tags);
    }
}
