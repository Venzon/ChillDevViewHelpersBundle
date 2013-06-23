<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.5
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Usage

## Helpers

-   [XHTML](./usage/xhtml.md)
-   [&lt;title&gt;](./usage/title.md)
-   [&lt;meta&gt;](./usage/meta.md)
-   [&lt;link&gt;](./usage/link.md)
-   [&lt;script&gt;](./usage/script.md)
-   [xmlns](./usage/xmlns.md)
-   [Standalone](./usage/standalone.md)
-   [Paginator](./usage/paginator.md)
-   [Serializer](./usage/serializer.md)
-   [Formatter](./usage/formatter.md)

## Paths resolving

Our view helpers bundle allows you to customize way, in which assets paths are resolved. To make it more compact, instead of generating paths on your own, you can use prefix, for example instead of:

```php
$view['script']->add($view['asset']->getUrl('javascript/prototype.js'));
```

You can use:

```php
$view['script']->add('@assets:javascript/prototype.js');
```

The prefixed path must have form of: `@prefix:path`. Currently `script` and `link` helpers use paths resolving.

Initially there are two prefixes available, when helpers are used in full-stack **Symfony2**:

-   `@assets:`: resolves to `$view['assets']->getUrl()`;
-   `@base:`: resolved to `$app->getRequest()->getBaseUrl()`.

Using prefix that is not registered will result in no changes applied to initial path.

### Registering own prefixes

To register handler for new prefix, first you need to implement it - all you need is to implement single-method interface `ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\TransformerInterface`:

```php

namespace Application\PathResolver\Transformer;

use ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\TransformerInterface;

class Download implements TransformerInterface
{
    public function transform($path)
    {
        // this method will be called, when path will be resolved
        // - you can transform the path here as you want
        // - you need to return resulted path
        // - path passed as an argument will have stripped prefix
        // - your transformer should not relay, and even not be aware of prefix used for path
    }
}
```

Later, you need to register handler for own prefix by defining DI service with `chilldev.viewhelpers.path_transformer` tag. When adding this tag you need to specify it's `prefix` attribute to desired paths prefix. For example to register your transformer as handler for prefix `@download:` you need to define create following service:

```xml
<service id="application.path_transformer.download" class="Application\PathResolver\Transformer\Download">
    <tag name="chilldev.viewhelpers.path_transformer" prefix="download"/>
</service>
```

Now using:

```php
<?php $view['script']->add('@download:autostart.js'); ?>
```

Will use your resolver.

#### Different assets packages

The default path transformer, used for prefix `@assets:` is flexible enough to be used for any other assets package you defined for your application assets helper. It uses default package by default, but you can register another instance of this class with different package name to use another assets package prefix:

```xml
<service id="application.path_transformer.cdn" class=">ChillDev\Bundle\ViewHelpersBundle\PathResolver\Transformer\AssetsTransformer">
    <tag name="chilldev.viewhelpers.path_transformer" prefix="cdn"/>
    <argument type="service" id="templating.helper.assets"/>
    <argument>cdn</argument>
</service>
```
