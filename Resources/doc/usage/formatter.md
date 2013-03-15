<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.3
# @since 0.1.3
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Formatter

Formatter helper is just a wrapper around formatter that comes with [`SonataFormatterBundle`](https://github.com/sonata-project/SonataFormatterBundle). It's usage is as simple as:

```php
<?php echo $view['formatter']->transform('markdown', '# Header

Text paragraph.') ?>
```
