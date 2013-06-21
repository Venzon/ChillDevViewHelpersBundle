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

use Symfony\Component\Templating\Helper\CoreAssetsHelper;

/**
 * Assets URL transformer.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class AssetsTransformer implements TransformerInterface
{
    /**
     * Assets URL generator.
     *
     * @var CoreAssetsHelper
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $helper;

    /**
     * Assets package.
     *
     * @var string|null
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $package;

    /**
     * Initializes URL transformer.
     *
     * @param CoreAssetsHelper $helper Assets URL resolver.
     * @param string|null $package Package name.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function __construct(CoreAssetsHelper $helper, $package = null)
    {
        $this->helper = $helper;
        $this->package = $package;
    }

    /**
     * {@inheritDoc}
     */
    public function transform($path)
    {
        return $this->helper->getUrl($path, $this->package);
    }
}
