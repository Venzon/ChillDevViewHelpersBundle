<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

// bootstrap autoloading
require(__DIR__ . '/../../vendor/autoload.php');

use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Link;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Meta;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Script;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Title;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Helper\Xmlns;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Xhtml\Checker;
use ChillDev\Bundle\ViewHelpersBundle\Utils\Markup;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Storage\StringStorage;

// initialize templating engine
$templating = new PhpEngine(new TemplateNameParser(), new FilesystemLoader([]));

// markup generator
$markup = new Markup($templating);

// XHTML checker for view helpers
$checker = new Checker();

// <title> helper
$title = new Title($templating);
$templating->set($title);

// <meta> helper
$meta = new Meta($templating, $checker, $markup);
$templating->set($meta);

// <link> helper
$link = new Link($templating, $checker, $markup);
$templating->set($link);

// <script> helper
$script = new Script($templating, $checker, $markup);
$templating->set($script);

// xmlns="" helper
$xmlns = new Xmlns($templating);
$templating->set($xmlns);

// sample pre-defined data
$title->setSeparator(' :: ')
    ->append('<Root>', 'Category');
$meta->setMetaName('description', 'Chillout Development ViewHelpers Bundle')
    ->setProperty('og:title', 'ChillDev\\Bundle\\ViewHelpersBundle');
$link->addStylesheet('style/style.css')
    ->add('images/favicon.png', ['shortcut', 'icon'], 'image/png');
$script->add('javascript/app.js', Element::TYPE_APPLICATIONJAVASCRIPT)
    ->add('javascript/stats.js', Element::TYPE_APPLICATIONJAVASCRIPT, Element::FLOW_ASYNC);
$xmlns['http://www.w3.org/1999/xhtml'] = '';

echo $templating->render(__DIR__ . '/template.php', [
        'title' => 'Page',
]);
