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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use ArrayObject;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Link\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\HelperInterface;

/**
 * &lt;link&gt; tag helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.0
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Link extends ArrayObject implements
    HelperInterface
{
    use ChangeableCharset;

    /**
     * Stylesheet rel value.
     *
     * @var string
     * @version 0.0.2
     * @since 0.0.2
     */
    const REL_STYLESHEET = 'stylesheet';

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
     * Initializes templating helper.
     *
     * @param PhpEngine $templating Templating engine.
     * @param Checker $checker XHTML checker.
     * @version 0.0.1
     * @since 0.0.1
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
     * @version 0.1.0
     * @since 0.0.1
     */
    public function add($href, $rels, $type = null, $media = null)
    {
        // allow to pass single string as rel value
        if (\is_string($rels)) {
            $rels = [$rels];
        }

        $this[] = new Element($this->templating, $this->checker, $href, $rels, $type, $media);

        return $this;
    }

    /**
     * Adds new stylesheet link.
     *
     * @param string $href Link target.
     * @param string $media Media query.
     * @param string $type MIME type.
     * @return self Self instance.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheet($href, $media = null, $type = 'text/css')
    {
        return $this->add($href, self::REL_STYLESHEET, $type, $media);
    }

    /**
     * Adds multiple new stylesheets links.
     *
     * @param string[] $hrefs Links targets.
     * @param string $media Media query.
     * @param string $type MIME type.
     * @return self Self instance.
     * @version 0.0.2
     * @since 0.0.2
     */
    public function addStylesheets(array $hrefs, $media = null, $type = 'text/css')
    {
        foreach ($hrefs as $href) {
            $this->addStylesheet($href, $media, $type);
        }

        return $this;
    }

    /**
     * Finds all currently set links by given relation.
     *
     * @param string $rel Link relation.
     * @return Element[] Found links.
     * @version 0.1.0
     * @since 0.0.1
     */
    public function getByRel($rel)
    {
        $links = [];

        // find all links by given rel
        foreach ($this as $link) {
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
     * @version 0.1.0
     * @since 0.0.1
     */
    public function delete(Element $link)
    {
        if (($index = \array_search($link, $this->getArrayCopy(), true)) !== false) {
            unset($this[$index]);
        }

        return $this;
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

        // generate <link> tags
        foreach ($this as $link) {
            $tags[] = (string) $link;
        }

        return \implode($tags);
    }
}
