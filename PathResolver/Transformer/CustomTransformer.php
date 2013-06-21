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

namespace ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer;

/**
 * Simple map transformer.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class CustomTransformer implements TransformerInterface
{
    /**
     * Root path.
     *
     * @var string
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $basePath;

    /**
     * Initializes transformer for given path.
     *
     * @param string $basePath Base path for transofmrations.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function transform($path)
    {
        return $this->basePath . $path;
    }
}
