<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.2
# @since 0.0.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# &lt;link&gt; tags

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

`add()` method implements fluent interface. There is also a handy shortcut method for adding stylesheets - `addStylesheet()`. It assums that your link has `rel="stylesheet"` and sets default MIME-Type to `text/css`. For stylesheets you more often change media query then MIME-Type, so order of last two arguments is inversed:

```php
<?php $view['link']->addStylesheet('/styles/style.css')
    ->addStylesheet('/styles/print.css', 'print'); ?>
```

Even shorter way to add multiple stylesheets is `addStylesheets()` method, which simply adds all links from given array (second parameter defined media query and third - MIME-Type for all links added in given call):

```php
<?php $view['link']->addStylesheets([
        '/styles/base.css',
        '/styles/forms.css',
        '/styles/grids.css',
]); ?>
```

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
