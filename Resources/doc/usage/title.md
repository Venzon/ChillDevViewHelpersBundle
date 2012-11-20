<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.2
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# &lt;title&gt; tag

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
<?php /* in your main layout */ ?>
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
