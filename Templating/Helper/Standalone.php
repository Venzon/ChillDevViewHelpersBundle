<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper;
use Symfony\Component\Templating\Helper\Helper;

/**
 * Shortcut helper for internal requests.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class Standalone extends Helper
{
    /**
     * Sub-requests helper.
     *
     * @var ActionsHelper
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $actions;

    /**
     * Initializes templating helper.
     *
     * @param ActionsHelper $actions Actions helper.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function __construct(ActionsHelper $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Renders sub-request.
     *
     * @param string $controller Controller reference.
     * @param
     * @return string Rendered fragment.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function render($controller, $options = [], array $attributes = [], array $query = [])
    {
        // use $options as shortcut for strategy
        if (!\is_array($options)) {
            $options = ['strategy' => $options];
        }

        return $this->actions->render(
            $this->actions->controller($controller, $attributes, $query),
            $options
        );
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getName()
    {
        return 'standalone';
    }
}
