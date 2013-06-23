<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 - 2015 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.5
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# &lt;script&gt; tags

`<script>` tags can be managed with `$view['script']` helper. To add new script use `$view['script']->add()` which takes following arguments:

-   `$src` **required**, script location;
-   `$type` *optional*, target MIME type, `text/javascript` by default;
-   `$flow` *optional*, execution flow - by default no special flow-control attribute is applied, use can use `ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element::FLOW_DEFER` to defined `defer="defer"` attribute or `ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element::FLOW_ASYNC` for `async="async"`;
-   `$charset` *optional*, script charset.

**Note:** You can only choose one of `Element::FLOW_DEFER` and `Element::FLOW_ASYNC` by passing argument value, since defining them both makes no sense.

```php
<?php $view['script']->add('/javascript/prototype.js')
    ->add('/javascript/date.js', 'application/javascript')
    ->add('/javascript/s2.js', 'application/javascript', Element::FLOW_DEFER); ?>
```

As you can see `add()` method implements fluent interface. For adding multiple scripts at once you can use `addMany()` method which takes array of strings instead of string as first argument and adds each script from list:

```php
<?php $view['script']->addMany([
        '/javascript/prototype.js',
        '/javascript/s2.js',
]); ?>
```

There is also `delete()` method which allows you to *unset* not-needed script by it's src attribute:

```php
<?php $view['script']->delete('/javascript/lightbox.js');?>
```

To output all defined scripts simply call:

```php
<html>
    <head>
        <?php echo $view['script']; ?>
        …
    </head>
    …
</html>
```

Script helper automatically escapes all attributes content.

**Note:** Depending on XHTML switch state helper will generate tags ended with `>` (for XHTML turned off, default), or `/>` (for enabled XHTML). Thus it's important to enable XHTML 
before rendering helper output. XHTML output also ommits `</script>` ending tag.

**Note:** `<script>` tag helper extends [`ArrayObject`](http://php.net/manual/en/class.arrayobject.php), so you can use standard methods to manage contained elements.

**Remember:** Even though `text/javascript` is a default value for `type=""` attribute of `<script>` element, it is obsolete - the really proper MIME type for **JavaScript** files is `application/javascript`!

## Paths resolving

You can use [paths resolved by prefixes](../usage.md#paths-resolving) when defining script source:

```php
<?php $view['script']->add('@assets:/javascript/prototype.js'); ?>
```
