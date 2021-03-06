<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use ArrayObject;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\PathResolver;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\HelperInterface;

/**
 * &lt;script&gt; tag helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Script extends ArrayObject implements
    HelperInterface
{
    use ChangeableCharset;

    /**
     * Templating engine.
     *
     * @var PhpEngine
     * @version 0.0.2
     * @since 0.0.2
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
     * Paths resolver.
     *
     * @var PathResolver
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $pathResolver;

    /**
     * Initializes templating helper.
     *
     * @param PhpEngine $templating Templating engine.
     * @param Checker $checker XHTML checker.
     * @param Markup $markup Markup generator.
     * @param PathResolver $pathResolver Paths resolver.
     * @version 0.1.5
     * @since 0.0.2
     */
    public function __construct(PhpEngine $templating, Checker $checker, Markup $markup, PathResolver $pathResolver)
    {
        $this->templating = $templating;
        $this->checker = $checker;
        $this->markup = $markup;
        $this->pathResolver = $pathResolver;
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getName()
    {
        return 'script';
    }

    /**
     * Adds new script.
     *
     * @param string $src Script location.
     * @param string $type MIME type.
     * @param int $flow Execution flow.
     * @param string $charset Script charset.
     * @return self Self instance.
     * @version 0.1.5
     * @since 0.0.2
     */
    public function add($src, $type = Element::TYPE_TEXTJAVASCRIPT, $flow = Element::FLOW_DEFAULT, $charset = null)
    {
        $src = $this->pathResolver->resolve($src);
        $this[] = new Element($this->templating, $this->checker, $this->markup, $src, $type, $flow, $charset);

        return $this;
    }

    /**
     * Adds multiple new scripts.
     *
     * @param string[] $srcs Script location.
     * @param string $type MIME type.
     * @param int $flow Execution flow.
     * @param string $charset Script charset.
     * @return self Self instance.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addMany(
        array $srcs,
        $type = Element::TYPE_TEXTJAVASCRIPT,
        $flow = Element::FLOW_DEFAULT,
        $charset = null
    ) {
        foreach ($srcs as $src) {
            $this->add($src, $type, $flow, $charset);
        }

        return $this;
    }

    /**
     * Deletes a script from container.
     *
     * @param string $src Script location.
     * @return self Self instance.
     * @version 0.1.0
     * @since 0.0.2
     */
    public function delete($src)
    {
        // find script by given src
        foreach ($this as $index => $script) {
            if ($script->getSrc() == $src) {
                unset($this[$index]);
                break;
            }
        }

        return $this;
    }

    /**
     * Generates string representation.
     *
     * @return string Text representation.
     * @version 0.1.0
     * @since 0.0.2
     */
    public function __toString()
    {
        $tags = [];

        // generate <script> tags
        foreach ($this as $script) {
            $tags[] = (string) $script;
        }

        return \implode($tags);
    }
}
