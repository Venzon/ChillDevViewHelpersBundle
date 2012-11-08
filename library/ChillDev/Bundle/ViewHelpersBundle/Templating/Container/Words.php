<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Container;

use ArrayObject;

/**
 * Common words container.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */
class Words extends ArrayObject
{
    /**
     * Content separator.
     *
     * @var string
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $separator = ',';

    /**
     * Initializes container.
     *
     * @param string $separator Separator for content parts.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct($separator = null)
    {
        parent::__construct();
        if (isset($separator)) {
            $this->setSeparator($separator);
        }
    }

    /**
     * Returns current separator.
     *
     * @return string Currently used separator.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Changes separator.
     *
     * @param string $separator New separator.
     * @return Words Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Appends one, ore more values at the end of current stack.
     *
     * @param mixed $value,... Additional value.
     * @return Words Self instance.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function append($value/*unused*/)
    {
        foreach (\func_get_args() as $value) {
            parent::append($value);
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
        return \implode($this->separator, $this->getArrayCopy());
    }
}
