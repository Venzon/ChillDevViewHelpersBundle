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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\Helper;

/**
 * &lt;script&gt; tag helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Script extends Helper
{
    /**
     * List of defined scripts.
     *
     * @var Element[]
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $scripts = [];

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
     * Initializes templating helper.
     *
     * @param PhpEngine $templating Templating engine.
     * @param Checker $checker XHTML checker.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function __construct(PhpEngine $templating, Checker $checker)
    {
        $this->templating = $templating;
        $this->checker = $checker;
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
     * @version 0.0.2
     * @since 0.0.2
     */
    public function add($src, $type = Element::TYPE_TEXTJAVASCRIPT, $flow = Element::FLOW_DEFAULT, $charset = null)
    {
        $this->scripts[] = new Element($this->templating, $this->checker, $src, $type, $flow, $charset);

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
     * @version 0.0.2
     * @since 0.0.2
     */
    public function delete($src)
    {
        // find script by given src
        foreach ($this->scripts as $index => $script) {
            if ($script->getSrc() == $src) {
                unset($this->scripts[$index]);
                break;
            }
        }

        return $this;
    }

    /**
     * Generates string representation.
     *
     * @return string Text representation.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function __toString()
    {
        $tags = [];

        // generate <script> tags
        foreach ($this->scripts as $script) {
            $tags[] = (string) $script;
        }

        return \implode($tags);
    }
}
