<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.0
# @since 0.1.0
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# xmlns="" attribute

This helper is simply container for XML namespaces definitions used by your document. Like many other helpers from this bundle, it is extension to [`ArrayObject`](http://php.net/manual/en/class.arrayobject.php). It aggregates all namespaces as `namespace => alias` map:

```php
<?php $view['xmlns']['http://ogp.me/ns/fb#'] = 'fb'; ?>
```

You can set default XML namespace by setting empty value for namespace:

```php
<?php $view['xmlns']['http://www.w3.org/1999/xhtml'] = ''; ?>
```

When namespace is registered you can then use helper also to produce prefix for elements with `getPrefix()` method:

```php
<<?php echo $view['xmlns']->getPrefix('http://ogp.me/ns/fb#'); ?>like/>
```

Which should produce:

```html
<fb:like/>
```

To output all defined `xmlns` attributes simply call:

```php
<html<?php echo $view['xmlns']; ?>>
    …
</html>
```

Output has leading space so you don't have to leave extra space between `html` element name and helper output.
