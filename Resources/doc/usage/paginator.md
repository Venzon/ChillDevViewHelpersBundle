<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.3
# @since 0.1.3
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Paginator

Paginator helper is just a PHP helper version of [`KnpPaginatorBundle`](https://github.com/KnpLabs/KnpPaginatorBundle). It's basic usage is as simple as:

```php
<?php echo $view['paginator']->render($pagination); ?>
```

It is 1-to-1 implementation of Twig extension from the same bundle. It provides three methods:

-   `render()` that renders pagination template,
-   `sortable()` for sorting links,
-   `filter()` for filtering.
