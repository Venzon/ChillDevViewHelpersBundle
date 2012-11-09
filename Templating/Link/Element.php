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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Link;

use Symfony\Component\Templating\PhpEngine;

/**
 * Single <link> tag representation.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Element
{
    /**
     * Link target.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $href;

    /**
     * Link relations.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $rels = [];

    /**
     * MIME type.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $type;

    /**
     * Destination media type.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $media;

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
     * @param string $href Link location.
     * @param string[] $rels Link relations.
     * @param string $type Link MIME type.
     * @param string $media Media query.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating, $href, array $rels, $type = null, $media = null)
    {
        $this->templating = $templating;
        $this->href = $href;
        $this->rels = $rels;
        $this->type = $type;
        $this->media = $media;
    }

    /**
     * Returns link target.
     *
     * @return string Link target.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Returns list of link relations.
     *
     * @return string[] Link relations.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getRels()
    {
        return $this->rels;
    }

    /**
     * Returns link MIME type.
     *
     * @return string Link MIME type.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns link media query.
     *
     * @return string Link media query.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Checks if link belongs to given relation.
     *
     * @param string $rel Relationship identifier.
     * @return bool Relationship flag.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function hasRel($rel)
    {
        return \in_array($rel, $this->rels);
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
        $data = [
            'href' => $this->href,
            'rel' => \implode(' ', $this->rels),
        ];

        // optional arguments
        if (isset($this->type)) {
            $data['type'] = $this->type;
        }
        if (isset($this->media)) {
            $data['media'] = $this->media;
        }

        // generate <link> tag
        $attrs = [];
        foreach ($data as $name => $content) {
            $attrs[] = ' ' . $name . '="' . $this->templating->escape($content) . '"';
        }

        return '<link' . \implode($attrs) . '/>';
    }
}
