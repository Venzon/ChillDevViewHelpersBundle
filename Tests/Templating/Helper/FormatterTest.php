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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use stdClass;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Formatter;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.1.3
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class FormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Sonata\FormatterBundle\Formatter\Pool
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $mock;

    /**
     * @var Formatter
     * @version 0.1.3
     * @since 0.1.3
     */
    protected $formatter;

    /**
     * @version 0.1.3
     * @since 0.1.3
     */
    protected function setUp()
    {
        $this->mock = $this->getMock('Sonata\\FormatterBundle\\Formatter\\Pool');
        $this->formatter = new Formatter($this->mock);
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function getHelperName()
    {
        $this->assertEquals('formatter', $this->formatter->getName(), 'Formatter::getName() should return helper alias.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function textFormatting()
    {
        $format = new stdClass();
        $text = new stdClass();

        $this->mock->expects($this->once())
            ->method('transform')
            ->with($this->identicalTo($format), $this->identicalTo($text));

        $this->formatter->transform($format, $text);
    }
}
