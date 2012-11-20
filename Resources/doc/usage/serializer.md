<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.2
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Serializer

Serializer helper is just a wrapper around serializer that comes with [`JMSSerializerBundle`](https://github.com/schmittjoh/JMSSerializerBundle). It's usage is as simple as:

```php
<?php echo $view['serializer']->serialize([
        'foo' => 'bar',
        'baz' => 'qux',
], 'json') ?>
```

Second parameter is optional, default output format is *JSON*.

## Sample layout

```php
<?php $view['xhtml'](); ?><?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $view['title']; ?>
        <?php echo $view['meta']; ?>
        <?php echo $view['link']; ?>
        …
    </head>
    <body>
        <?php $view['slots']->output('_content') ?>
    </body>
</html>
```
