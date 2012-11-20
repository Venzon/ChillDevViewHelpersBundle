<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.2
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# &lt;meta&gt; tags

Another container helper is `<meta>` tags helper. Meta tags are simple key-value stored dictionaries groupped within three containers depending on they key attributes: `name`, `property` and `http-equiv`.

Each of these groups has three dedicated methods that work completely the same way, just operates on different meta definitions set (since `getName()` method is reserved by Symfony's helper interface, for meta values keyed by name we use *MetaName*):

-   `setMetaName($key, $value)`, `setProperty($key, $value)`, `setHttpEquiv($key, $value)` - sets/changes meta value;
-   `getMetaName($key)`, `getProperty($key)`, `getHttpEquiv($key)` - returns meta value (empty string if not defined);
-   `unsetMetaName($key)`, `unsetProperty($key)`, `unsetHttpEquiv($key)` - removes meta value.

All of them implement fluent interface, so you can chain them:

```php
<?php $view['meta']->setMetaName('description', \strip_tags($site->getShort()))
    ->setProperty('og:title', $site->getName())
    ->unsetHttpEquiv('Content-Type'); ?>
```

To output all defined meta tags simply call:

```php
<html>
    <head>
        <?php echo $view['meta']; ?>
        …
    </head>
    …
</html>
```

Meta helper automatically escapes both key and content attributes content.

**Note:** meta value doesn't need to be a string - helper casts all values to strings, so you can put, for example, any object that has `__toString()` method.

## Keywords

Sample of special meta association is keywords container which is pre-defined as phrases container (object of class that extends [`ArrayObject`](http://php.net/manual/en/class.arrayobject.php), so you can use all of it's methods). To define new keywords, just call:

```php
<?php $view['meta']->getMetaName('keywords')->append('xhtml', 'chilldev', 'view helpers'); ?>
```
