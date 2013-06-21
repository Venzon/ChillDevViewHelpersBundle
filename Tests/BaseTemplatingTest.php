<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\PathResolver;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.2
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
abstract class BaseTemplatingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpEngine
     * @version 0.1.2
     * @since 0.1.2
     */
    protected $templating;

    /**
     * @var Checker
     * @version 0.1.2
     * @since 0.1.2
     */
    protected $checker;

    /**
     * Markup generator.
     *
     * @var Markup
     * @version 0.1.2
     * @since 0.1.2
     */
    protected $markup;

    /**
     * @var PathResolver
     * @version 0.1.5
     * @since 0.1.5
     */
    protected $pathResolver;

    /**
     * @version 0.1.2
     * @since 0.1.2
     */
    protected function setUp()
    {
        $this->templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));
        $this->checker = new Checker();
        $this->markup = new Markup($this->templating);
        $this->pathResolver = new PathResolver();
    }
}
