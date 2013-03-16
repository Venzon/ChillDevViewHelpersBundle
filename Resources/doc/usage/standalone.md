<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.3
# @since 0.1.3
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Standalone sub-requests

Standalone helper is shortcut for using `actions` helper from standard `FrameworkBundle` to render sub-requests. After dropping internal routing in **Symfony 2.2** using actions helper in PHP templating for sub-requests became a bit complicaated (calling both `render()` and `controller()` methods of the helpers). This helper shortens the notation - instead of:

```php
<?php $view['actions']->render($view['actions']->controller('Bundle:Controller:action')); ?>
```

you can do:

```php
<?php $view['standalone']->render('Bundle:Controller:action'); ?>
```

`standalone` helper takes three additional arguments - first is passed as additional options to `actions` helper; second and third are route attributes and URL query parameters used by controller reference.

Optionally a single string can be passed as options parameter and it will be used as a strategy identifier - for example:

```php
<?php $view['standalone']->render('Bundle:Controller:action', 'esi'); ?>
```

is equivalent to:

```php
<?php $view['standalone']->render('Bundle:Controller:action', ['strategy' => 'esi']); ?>
```
