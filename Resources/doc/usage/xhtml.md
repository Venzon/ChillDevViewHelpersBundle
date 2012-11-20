<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.2
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# XHTML Content-Type

Changing Content-Type to real-XHTML (`application/xhtml+xml`) is as easy as:

```php
<?php $view['xhtml']->setXhtml(); ?>
```

Note, that you don't need to pass any parameter - this call enabled XHTML by default. If you want to disable XHTML pass `false`:

```php
<?php $view['xhtml']->setXhtml(false); ?>
```

XHTML helper implements `__invoke()` magic method which allows you to use it in even more compact way:

```php
<?php $view['xhtml'](); ?>
```

**Note:** remember that you need to enable XHTML in your application [configuration](../configuration.md) first.

Checking XHTML switch has also some side effects on other helpers (for example `>` vs. `/>` tag endings).
