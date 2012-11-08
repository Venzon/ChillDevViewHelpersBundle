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

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\Templating\Helper;

use stdClass;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Serializer;

use JMS\SerializerBundle\Serializer\SerializerInterface;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */
class SerializerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockSerializer
     * @version 0.0.1
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
        $this->mock = new MockSerializer();
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
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultSerializationFormat()
    {
        $data = new stdClass();

        $this->serializer->serialize($data);

        $this->assertSame($data, $this->mock->data, 'Serializer::serialize() should pass data to serializer.');
        $this->assertEquals('json', $this->mock->format, 'Serializer::serialize() should serialize to JSON by default.');
    }

    /**
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function customSerializationFormat()
    {
        $data = new stdClass();
        $format = 'foo';

        $this->serializer->serialize($data, $format);

        $this->assertSame($data, $this->mock->data, 'Serializer::serialize() should pass data to serializer.');
        $this->assertEquals($format, $this->mock->format, 'Serializer::serialize() should serialize to specified format.');
    }
}

class MockSerializer implements SerializerInterface
{
    public $data;
    public $format;

    public function serialize($data, $format)
    {
        $this->data = $data;
        $this->format = $format;
    }

    public function deserialize($data, $type, $format)
    {
        // dummy
    }
}
