<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Usage

## XHTML Content-Type

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

**Note:** remember that you need to enable XHTML in your application [configuration](./configuration.md) first.

## &lt;title&gt; tag

This helper allows you to sequentially add title pieces and concat them just at displaying which make it possible to organise the title depending on particular page needs:

```php
<?php /* in your page view */
$view['title']->append($page->getName()); ?>
```

```php
<?php /* in your KnpPaginator template */
if ($current > 1) {
    $view['title']->append('Page ' . $current);
} ?>
```

```php
<?php /* in your main layout */
<html>
    <head>
        <?php echo $view['title']->setSeparator(' :: '); ?>
        …
    </head>
    …
</html>
```

`<title>` tag helper is in fact just a container that extends [`ArrayObject`](http://php.net/manual/en/class.arrayobject.php). This means that you can in fact manipulate the title content without any new methods:

```php
<?php unset($view['title'][0]); ?>
```

The only three differences from original `ArrayObject` class are:

-   helper class handles casting to string with `__toString()` method, which means you can output helper content directly, without invoking conversion manualy (helper automatically escapes content and wrapps it within `<title>…</title>` tags);
-   helper's `append()` method accepts variable list of arguments, which means you can pass multiple title parts at once and all of them will be added; also this method implements fluent interface, so you can chain calls;
-   helper class implements `setSeparator()` method which allows you to define custom glue string part which will be injected between all title parts.

## &lt;meta&gt; tags

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

### Keywords

Sample of special meta association is keywords container which is pre-defined as phrases container (object of class that extends [`ArrayObject`](http://php.net/manual/en/class.arrayobject.php), so you can use all of it's methods). To define new keywords, just call:

```php
<?php $view['meta']->getMetaName('keywords')->append('xhtml', 'chilldev', 'view helpers'; ?>
```

## &lt;link&gt; tags

Very similar like `<meta>` tags you can define `<link>` tags with `$view['link']->add()` method. This method taks four arguments:

-   `$href` **required**, link target;
-   `$rels` **required**, link relationships (list of strings, or single string if link has only one relationship);
-   `$type` *optional*, target MIME type;
-   `$media` *optional*, media query.

```php
<?php $view['link']->add('http://example.com/page-2-slug.html', 'next')
    ->add('/styles/style.css', 'stylesheet', 'text/css')
    ->add('/styles/print.css', 'stylesheet', 'text/css', 'print')
    ->add('/images/favicon.png', ['shortcut', 'icon']); ?>
```

`add()` method implements fluent interface.

You can manipulate contained links with `getByRel()` and `delete()` methods. First of them returns array of `ChillDev\Bundle\ViewHelpersBundle\Templating\Link\Element` objects that match specified relationship; `delete()` method removes specified element from the collection (`delete()` method implements fluent interface):

```php
<?php foreach ($view['link']->getByRel('stylesheet') as $element) {
    if ($element->getMedia() === 'print') {
        $view['link']->delete($element);
    }
} ?>
```

To output all defined links simply call:

```php
<html>
    <head>
        <?php echo $view['link']; ?>
        …
    </head>
    …
</html>
```

Link helper automatically escapes all attributes content.

## Serializer

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
