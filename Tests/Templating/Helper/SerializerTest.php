<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use stdClass;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Serializer;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.2
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class SerializerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var JMS\SerializerBundle\Serializer\SerializerInterface
     * @version 0.1.2
     * @since 0.0.1
     */
    protected $mock;

    /**
     * @var Serializer
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $serializer;

    /**
     * @version 0.0.1
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->mock = $this->getMock('JMS\\SerializerBundle\\Serializer\\SerializerInterface');
        $this->serializer = new Serializer($this->mock);
    }

    /**
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getHelperName()
    {
        $this->assertEquals('serializer', $this->serializer->getName(), 'Serializer::getName() should return helper alias.');
    }

    /**
     * @test
     * @version 0.1.2
     * @since 0.0.1
     */
    public function defaultSerializationFormat()
    {
        $data = new \stdClass();
        $toReturn = new \stdClass();

        $this->mock->expects($this->once())
            ->method('serialize')
            ->with($this->identicalTo($data), $this->equalTo('json'))
            ->will($this->returnValue($toReturn));

        $return = $this->serializer->serialize($data);
        $this->assertSame($toReturn, $return, 'Serializer::serialize() should return result of serializer operation.');
    }

    /**
     * @test
     * @version 0.1.2
     * @since 0.0.1
     */
    public function customSerializationFormat()
    {
        $data = new \stdClass();
        $format = 'foo';

        $this->mock->expects($this->once())
            ->method('serialize')
            ->with($this->identicalTo($data), $this->equalTo($format));

        $this->serializer->serialize($data, $format);
    }
}
