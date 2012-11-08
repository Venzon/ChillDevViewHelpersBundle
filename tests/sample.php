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

// bootstrap autoloading
require(__DIR__ . '/../vendor/autoload.php');

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Serializer;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Title;

use JMS\SerializerBundle\Serializer\SerializerInterface;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Storage\StringStorage;

// initialize templating engine
$templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));

// <title> helper
$title = new Title($templating);
$templating->set($title);

// to reduce dependencies here is simple JSON serializer
class JsonSerializer implements SerializerInterface
{
    public function serialize($data, $format)
    {
        return json_encode($data);
    }

    public function deserialize($data, $type, $format)
    {
        // dummy
    }
}

// JMS serializer helper
$templating->set(new Serializer(new JsonSerializer()));

// sample pre-defined data
$title->setSeparator(' :: ')
    ->append('<Root>', 'Category');

echo $templating->render(__DIR__ . '/template.php', [
        'title' => 'Page',
]);
