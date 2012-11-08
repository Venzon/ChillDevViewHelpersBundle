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

namespace ChillDev\Bundle\ViewHelpersBundle\Templating\Helper;

use JMS\SerializerBundle\Serializer\SerializerInterface;

use Symfony\Component\Templating\Helper\Helper;

/**
 * Serializer helper.
 *
 * This is PHP helper, since JMSSerializerBundle provides only one for Twig.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */
class Serializer extends Helper
{
    /**
     * Serializer.
     *
     * @var SerializerInterface
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $serializer;

    /**
     * Initializes object.
     *
     * @param SerializerInterface $serializer Serializaer service.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Performs inline serialization.
     *
     * @param mixed $object Data to serialize.
     * @param string $type Output format.
     * @return string Serialized data.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function serialize($object, $type = 'json')
    {
        return $this->serializer->serialize($object, $type);
    }

    /**
     * Returns helpers alias.
     *
     * @return string Helper name.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function getName()
    {
        return 'serializer';
    }
}
