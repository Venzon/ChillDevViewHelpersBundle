<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.2
# @since 0.1.2
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Extras

**ChillDevViewHelpersBundle** comes with, apart from handy view helpers, some extras that you can usually need if you create templates in plain PHP and use common bundles - most of them provide support for PHP templates, but does not provide full, rich resources out-of-the-box.

## KnpPaginatorBundle

One of such examples is [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) - it has full support for PHP templating, including view helpers, but there is no default pagination template.

In this bundle you can find it under `Resources/views/Pagination/sliding.html.php`. All you need to do in order to use it in your project is to set **KnpPaginatorBundle** to use it:

```yaml
# KNP paginator configuration
knp_paginator:
    template:
        pagination: "ChillDevViewHelpersBundle:Pagination:sliding.html.php"
```
