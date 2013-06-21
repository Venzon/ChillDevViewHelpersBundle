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

use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;

/**
 * Request URL transformer.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class RequestTransformer implements TransformerInterface
{
    /**
     * Request container.
     *
     * @var GlobalVariables
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $globals;

    /**
     * Initializes URL transformer.
     *
     * @param GlobalVariables $globals Request container.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function __construct(GlobalVariables $globals)
    {
        /*
         * FIXME:
         * for now we rely on GlobalVariables for Symfony 2.1 and 2.2 compatibility,
         * in 2.3 we can just use synchronized service definition in DI
         */
        $this->globals = $globals;
    }

    /**
     * {@inheritDoc}
     * @version 0.1.5
     * @since 0.1.5
     */
    public function transform($path)
    {
        return $this->globals->getRequest()->getBaseUrl() . $path;
    }
}
