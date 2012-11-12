<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# ChillDev ViewHelpers bundle

**ChillDevViewHelpersBundle** is a **Symfony2 bundle** that brings set of useful view helpers for PHP templating engine.

[![Build Status](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle.png)](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle])

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

Of course there are some optional [configuration options](./Resources/doc/configuration.md).

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
```

In your layout file:

```php
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:hx="http://purl.org/NET/hinclude" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <?php echo $view['title']; ?>
        <?php echo $view['meta']; ?>
        <?php echo $view['link']; ?>
    </head>
    <body>
        <?php $view['slots']->output('_content') ?>
    </body>
</html>
```

For more advanced aspects see [advanced usage documentation](./Resources/doc/usage.md) or even [internals description](./Resources/doc/internals.md).

# Resources

-   [Source documentation](./Resources/doc/index.md)
-   [GitHub page with API documentation](https://chilloutdevelopment.github.com/ChillDevViewHelpersBundle/)
-   [Travis CI](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle)
-   [Issues tracker](https://github.com/chilloutdevelopment/ChillDevViewHelpersBundle/issues)
-   [Packagist package](https://packagist.org/packages/chilldev/view-helpers-bundle)
-   [Chillout Development @ GitHub](https://github.com/chilloutdevelopment/)
-   [Chillout Development @ Facebook](http://www.facebook.com/chilldev)

# Contributing

Do you want to help improving this project? Simply *fork* it and post a pull request. You can do everything on your own, you don't need to ask if you can, just do all the awesome things you want!

This project is published under [MIT license](./LICENSE).

# Authors

**ChillDevViewHelpersBundle** is brought to you by [Chillout Development](http://chilldev.pl).

List of contributors:

-   [Rafał "Wrzasq" Wrzeszcz](https://github.com/rafalwrzeszcz) ([wrzasq.pl](http://wrzasq.pl)).
