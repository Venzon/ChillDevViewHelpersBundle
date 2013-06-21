<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\PathResolver;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\TransformerInterface;

/**
 * URL translations broker.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class PathResolver
{
    /**
     * Map of registered transformers.
     *
     * @var array
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $transformers = [];

    /**
     * Register new prefix.
     *
     * @param string $prefix Paths prefix.
     * @param TransformerInterface $transformer Transformation handler.
     * @return self Self instance.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function registerTransformer($prefix, TransformerInterface $transformer)
    {
        $this->transformers[$prefix] = $transformer;

        return $this;
    }

    /**
     * Resolves path.
     *
     * @param string $path Original path.
     * @return string Resolved path.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function resolve($path)
    {
        // to save resources only take care about paths that start with '@'
        if ($path[0] == '@') {
            if (preg_match('#^@([^:]+):(.*)$#', $path, $match) && isset($this->transformers[$match[1]])) {
                $path = $this->transformers[$match[1]]->transform($match[2]);
            }
        }

        return $path;
    }
}
