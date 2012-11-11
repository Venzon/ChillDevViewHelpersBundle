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

use ChillDev\Bundle\ViewHelpersBundle\Templating\Link\Element;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\Helper;

/**
 * &lt;link&gt; tag helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Link extends Helper
{
    /**
     * List of defined links.
     *
     * @var Element[]
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $links = [];

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
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating)
    {
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
        return 'link';
    }

    /**
     * Adds new link.
     *
     * @param string $href Link target.
     * @param string[]|string $rels Link relations.
     * @param string $type MIME type.
     * @param string $media Media query.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function add($href, $rels, $type = null, $media = null)
    {
        // allow to pass single string as rel value
        if (\is_string($rels)) {
            $rels = [$rels];
        }

        $this->links[] = new Element($this->templating, $href, $rels, $type, $media);

        return $this;
    }

    /**
     * Finds all currently set links by given relation.
     *
     * @param string $rel Link relation.
     * @return Element[] Found links.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getByRel($rel)
    {
        $links = [];

        // find all links by given rel
        foreach ($this->links as $link) {
            if ($link->hasRel($rel)) {
                $links[] = $link;
            }
        }

        return $links;
    }

    /**
     * Deletes a link.
     *
     * @param Element $link Link tag to delete.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function delete(Element $link)
    {
        if (($index = \array_search($link, $this->links, true)) !== false) {
            unset($this->links[$index]);
        }

        return $this;
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

        // generate <link> tags
        foreach ($this->links as $link) {
            $tags[] = (string) $link;
        }

        return \implode($tags);
    }
}
