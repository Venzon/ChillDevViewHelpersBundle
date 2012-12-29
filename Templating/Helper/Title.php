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

use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Words;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\HelperInterface;

/**
 * &lt;title&gt; tag helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Title extends Words implements
    HelperInterface
{
    use ChangeableCharset;

    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $templating;

    /**
     * Initializes templating helper.
     *
     * @param PhpEngine $templating Templating engine.
     * @param string $separator Separator for content parts.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating, $separator = null)
    {
        parent::__construct($separator);
        $this->templating = $templating;
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
        return 'title';
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
        return '<title>' . $this->templating->escape(parent::__toString()) . '</title>';
    }
}
