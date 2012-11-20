<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Meta as Container;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Helper\Helper;

/**
 * &lt;meta&gt; tags helper.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Meta extends Helper
{
    /**
     * List of meta tags containers.
     *
     * @var Container[]
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $meta = [];

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
     * @param Checker $checker XHTML checker.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(PhpEngine $templating, Checker $checker)
    {
        $this->templating = $templating;
        $this->meta['name'] = new Container($templating, $checker, 'name');
        $this->meta['property'] = new Container($templating, $checker, 'property');
        $this->meta['http-equiv'] = new Container($templating, $checker, 'http-equiv');
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
        return 'meta';
    }

    /**
     * Returns current meta name value.
     *
     * @param string $key Meta-variable name.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getMetaName($key)
    {
        return isset($this->meta['name'][$key]) ? $this->meta['name'][$key] : '';
    }

    /**
     * Sets meta name value.
     *
     * @param string $key Meta-variable name.
     * @param mixed $value Variable value.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setMetaName($key, $value)
    {
        $this->meta['name'][$key] = $value;

        return $this;
    }

    /**
     * Deletes meta name value.
     *
     * @param string $key Meta-variable name.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function unsetMetaName($key)
    {
        unset($this->meta['name'][$key]);

        return $this;
    }

    /**
     * Returns current meta property value.
     *
     * @param string $key Meta-variable name.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getProperty($key)
    {
        return isset($this->meta['property'][$key]) ? $this->meta['property'][$key] : '';
    }

    /**
     * Sets meta property value.
     *
     * @param string $key Meta-variable name.
     * @param mixed $value Variable value.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setProperty($key, $value)
    {
        $this->meta['property'][$key] = $value;

        return $this;
    }

    /**
     * Deletes meta property value.
     *
     * @param string $key Meta-variable name.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function unsetProperty($key)
    {
        unset($this->meta['property'][$key]);

        return $this;
    }

    /**
     * Returns current meta HTTP-equiv value.
     *
     * @param string $key Meta-variable name.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getHttpEquiv($key)
    {
        return isset($this->meta['http-equiv'][$key]) ? $this->meta['http-equiv'][$key] : '';
    }

    /**
     * Sets meta HTTP-equiv value.
     *
     * @param string $key Meta-variable name.
     * @param mixed $value Variable value.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setHttpEquiv($key, $value)
    {
        $this->meta['http-equiv'][$key] = $value;

        return $this;
    }

    /**
     * Deletes meta HTTP-equiv value.
     *
     * @param string $key Meta-variable name.
     * @return self Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function unsetHttpEquiv($key)
    {
        unset($this->meta['http-equiv'][$key]);

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

        // produce all containers string representation
        foreach ($this->meta as $container) {
            $tags[] = (string) $container;
        }

        return \implode($tags);
    }
}
