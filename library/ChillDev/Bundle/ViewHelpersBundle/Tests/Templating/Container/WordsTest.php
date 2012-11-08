<?php

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Container;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Container\Words;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */
class WordsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Check if separator passed to constructor is remembered.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function separatorFromConstructor()
    {
        $separator = '!';

        $words = new Words($separator);
        $this->assertEquals($separator, $words->getSeparator(), 'Words::__construct() should set separator passed as argument.');
    }

    /**
     * Check if separator set explicitely is remembered.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function separatorFromSetSeparator()
    {
        $separator = '!';

        $words = new Words();
        $words->setSeparator($separator);
        $this->assertEquals($separator, $words->getSeparator(), 'Words::setSeparator() should change separator.');
    }

    /**
     * Check if all arguments passed to append() are stored.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function multiAppend()
    {
        $value1 = 'foo';
        $value2 = 'bar';

        $words = new Words();
        $words->append($value1, $value2);
        $this->assertEquals($value1, $words[0], 'Words::append() should remember all values passed to it, in correct order.');
        $this->assertEquals($value2, $words[1], 'Words::append() should remember all values passed to it, in correct order.');
    }

    /**
     * Check to-string conversion.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function toStringConversion()
    {
        $separator = '!';
        $value1 = 'foo';
        $value2 = 'bar';

        $words = new Words($separator);
        $words->append($value1, $value2);
        $this->assertEquals($value1 . $separator . $value2, $words->__toString(), 'Words::__toString() should concat all elements glued with separator.');
    }

    /**
     * Check to-string casting.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function toStringCasting()
    {
        $separator = '!';
        $value1 = 'foo';
        $value2 = 'bar';

        $words = new Words($separator);
        $words->append($value1, $value2);
        $this->assertEquals($value1 . $separator . $value2, (string) $words, 'Words::__toString() should handle conversion to string.');
    }
}
