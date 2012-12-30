<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Script;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

use Symfony\Component\Templating\PhpEngine;

/**
 * Single &lt;script&gt; tag representation.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Element
{
    /**
     * Normal execution flow.
     *
     * @var int
     * @version 0.0.2
     * @since 0.0.2
     */
    const FLOW_DEFAULT = 0;

    /**
     * Script execution defered after page is loaded.
     *
     * @var int
     * @version 0.0.2
     * @since 0.0.2
     */
    const FLOW_DEFER = 1;

    /**
     * Asynchronous script execution.
     *
     * @var int
     * @version 0.0.2
     * @since 0.0.2
     */
    const FLOW_ASYNC = 2;

    /**
     * Default JavaScript MIME type.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    const TYPE_TEXTJAVASCRIPT = 'text/javascript';

    /**
     * *The proper* JavaScript MIME type.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    const TYPE_APPLICATIONJAVASCRIPT = 'application/javascript';

    /**
     * Script source.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $src;

    /**
     * MIME type.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $type;

    /**
     * Execution flow.
     *
     * @var int
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $flow;

    /**
     * Charset used by script.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    protected $charset;

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
     * Initializes templating helper.
     *
     * @param PhpEngine $templating Templating engine.
     * @param Checker $checker XHTML checker.
     * @param Markup $markup Markup generator.
     * @param string $src Script location.
     * @param string $type Link MIME type.
     * @param int $flow Loading flow.
     * @param string $charset Script charset.
     * @version 0.1.0
     * @since 0.0.2
     */
    public function __construct(
        PhpEngine $templating,
        Checker $checker,
        Markup $markup,
        $src,
        $type = self::TYPE_TEXTJAVASCRIPT,
        $flow = self::FLOW_DEFAULT,
        $charset = null
    ) {
        $this->templating = $templating;
        $this->checker = $checker;
        $this->markup = $markup;
        $this->src = $src;
        $this->type = $type;
        $this->flow = $flow;
        $this->charset = $charset;
    }

    /**
     * Returns script location.
     *
     * @return string Script location.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Returns link MIME type.
     *
     * @return string Link MIME type.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns execution flow.
     *
     * @return int Execution flow.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * Returns script scharset.
     *
     * @return string Script charset.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function getCharset()
    {
        return $this->charset;
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
        $data = [
            'src' => $this->src,
        ];

        // optional arguments
        if (isset($this->type)) {
            $data['type'] = $this->type;
        }
        if (isset($this->charset)) {
            $data['charset'] = $this->charset;
        }

        // specific loading flow - note that specyfing both async and defer at once makes no sense
        switch ($this->flow) {
            // defer="defer"
            case self::FLOW_DEFER:
                $data['defer'] = 'defer';
                break;
            // async="async"
            case self::FLOW_ASYNC:
                $data['async'] = 'async';
                break;
        }

        $isXhtml = $this->checker->isXhtml();
        $markup = $this->markup->generateElement('script', $data, $isXhtml);

        // in HTML <script> element needs closing tag
        if (!$isXhtml) {
            $markup .= '</script>';
        }

        return $markup;
    }
}
