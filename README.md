<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.4
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# ChillDev ViewHelpers bundle

**ChillDevViewHelpersBundle** is a **Symfony2 bundle** that brings set of useful view helpers for PHP templating engine.

[![Build Status](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle.png)](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle)

Because not everyone uses Twig…

# Installation

This bundle is provided as [Composer package](https://packagist.org/packages/chilldev/view-helpers-bundle). To install it simply add following dependency definition to your `composer.json` file:

```
"chilldev/view-helpers-bundle": "dev-master"
```

Replace `dev-master` with different constraint if you want to use specific version.

**Note:** This bundle requires **PHP 5.4**.

# Configuration

All you need to do in order to use this bundle's goods is to load it in your kernel:

```php
<?php

use ChillDev\Bundle\ViewHelpersBundle\ChillDevViewHelpersBundle;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    public function registerBundles()
    {
        $bundles = [
            new ChillDevViewHelpersBundle(),
        ];
    }
}
```

Of course there are some optional [configuration options](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/tree/master/Resources/doc/configuration.md).

# Usage

Major feature of this bundle is set of common (X)HTML tag helpers like `<meta>`, `<link>` etc. Here is sample usage:

In your view file:

```php
<?php $view->extend('::layout.html.php'); ?>

<?php $view['title']->append($page->getName()); ?>
<?php $view['meta']->getMetaName('keywords')->append($page->getKeywords()); ?>
<?php $view['meta']->setMetaName('description', \strip_tags($page->getDescription())); ?>
<?php $view['meta']->setProperty('og:title', $page->getName()); ?>
<?php $view['link']->add('http://example.com/page-2-slug.html', 'next'); ?>
<?php $view['script']->add('/javascript/prototype.js'); ?>
<?php $view['xmlns']['http://www.w3.org/1999/xhtml'] = ''; ?>
<?php $view['xmlns']['http://purl.org/NET/hinclude'] = 'hx'; ?>
<?php $view['xmlns']['http://ogp.me/ns#'] = 'og'; ?>
<?php $view['xmlns']['http://ogp.me/ns/fb#'] = 'fb'; ?>
```

In your layout file:

```php
<!DOCTYPE html>
<html<?php echo $view['xmlns']; ?>>
    <head>
        <?php echo $view['title']; ?>
        <?php echo $view['meta']; ?>
        <?php echo $view['link']; ?>
        <?php echo $view['script']; ?>
    </head>
    <body>
        <?php $view['slots']->output('_content') ?>
    </body>
</html>
```

For more advanced aspects see [advanced usage documentation](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/tree/master/Resources/doc/usage.md) or even [internals description](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/tree/master/Resources/doc/internals.md).

# Extras

There are also some [extra resources](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/tree/master/Resources/doc/extras.md) included in this bundle that can be useful for your PHP-templates-based project.

[KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) supports PHP templating, but lacks default template for paginator helper. You can use one from this bundle with just following one setting in your application configuration:

```yaml
# KNP paginator configuration
knp_paginator:
    template:
        pagination: "ChillDevViewHelpersBundle:Pagination:sliding.html.php"
```

# Resources

-   [Source documentation](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/tree/master/Resources/doc/index.md)
-   [GitHub page with API documentation](http://chilloutdevelopment.github.io/ChillDevViewHelpersBundle)
-   [Travis CI](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle)
-   [Issues tracker](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/issues)
-   [Packagist package](https://packagist.org/packages/chilldev/view-helpers-bundle)
-   [Chillout Development @ GitHub](https://github.com/chilloutdevelopment)
-   [Chillout Development @ Facebook](http://www.facebook.com/chilldev)
-   [Post on Wrzasq.pl](http://wrzasq.pl/blog/chilldevviewhelpersbundle-php-templating-helpers-for-symfony-2.html)

# Contributing

Do you want to help improving this project? Simply *fork* it and post a pull request. You can do everything on your own, you don't need to ask if you can, just do all the awesome things you want!

This project is published under [MIT license](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/LICENSE).

# Authors

**ChillDevViewHelpersBundle** is brought to you by [Chillout Development](http://chilldev.pl).

List of contributors:

-   [Rafał "Wrzasq" Wrzeszcz](https://github.com/rafalwrzeszcz) ([wrzasq.pl](http://wrzasq.pl)).
