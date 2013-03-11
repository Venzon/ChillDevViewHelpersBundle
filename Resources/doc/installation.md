<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.3
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Installation

**Note:** this bundle requires **PHP 5.4**.

## Step 1: define composer dependency

Add `"chilldev/view-helpers-bundle": "dev-master"` to your `composer.json` file (replace `dev-master` with your desired constraint if you want to use particular version). Then run `composer.phar install`.

**Note:** `dev-master` is a reference to `master` branch which is **stable** - to use current development branch with latest updates use `dev-develop`.

There is also optional dependency, that you may, but don't have to install (it won't be installed automatically):

-   [Symfony HTTP Kernel component](https://github.com/symfony/HttpKernel): required if you want to use `xhtml` helper which binds for kernel events (if you use **Symfony2** you already have all Symfony components installed).

## Step 2: include bundle in your kernel

Simply add following lines to your kernel:

```php
<?php

// in your use-s addd:
use ChillDev\Bundle\ViewHelpersBundle\ChillDevViewHelpersBundle;

// in your kernel class:
public function registerBundles()
{
    // your bubdles list
    $bundles = [
        'ChillDevViewHelpersBundle',
        …
    ];

    …
}
```

## Step 3: configuration

No configuration is needed in order to use helpers. The only exception is use of XHTML content-type switch. To enable the switch you need to add minimal configuration to your application configuration file:

```yaml
chilldev_viewhelpers:
    xhtml: true
```

You can use bundle's configuration to pre-define some view settings, like keywords, links and meta tags - for details see [Configuration section](./configuration.md).
