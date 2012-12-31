<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.0
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Configuration

**ChillDevViewHelpersBundle** requires no configuration at startup. You can however use bundle's configuration to pre-define some initial templating values. Bundle's configuration namespace is `chilldev_viewhelpers`.

## XHTML

In order to enable XHTML Content-Type fix you have to enable it in configuration first:

```yaml
chilldev_viewhelpers:
    xhtml: true
```

However this won't automatically send your pages as XHTML - this only enables the helper and registers event listener. This is because even if you create your application fully XHTML, you still probably have a lot of 3-rd party pages, like Symfony standard debug pages, profiler and web developer toolbar for example, which aren't XHTML-compatible. It is a lot better and safer to set it explicitely on sites that you are sure are completely XHTML-compatible. Usualy it's just fine to use helper in your main layout.

## &lt;title&gt;

`<title>` tag helper configuration provides two properties - `base` which is the default first element of page title (if not defined initial title will be empty) and `separator` which defines the string which will be used to glue all the parts together when displaying.

```yaml
chilldev_viewhelpers:
    title:
        base: "ChillDev ViewHelpers bundle"
        separator: " :: " # defaults to " - "
```

## &lt;link&gt;

`<link>` tag helper configuration allows you to define initial references that will be applied to helper on each site:

```yaml
chilldev_viewhelpers:
    links:
        -
            href: "http://static.chilldev.pl/images/favicon.png" # required
            rels: # required, you can use single string here if your link has just one rel value
                - "shortcut"
                - "icon"
            type: "image/png" # optional, but depending on link tyle it may be needed
            media: "screen" # optional
```

### Stylesheets

Most common use of `<link>` element is to define external stylesheets. You can use `stylesheets` key for shorter notation - it requires only `href` key, `type` is by default of value *text/css* and `rel` is always *stylesheet*:

```yaml
chilldev_viewhelpers:
    stylesheets:
        -
            href: "/styles/main.css" # required
            media: "screen" # optional
            type: "text/css" # optional, this is default value
```

You can even use shorthand notation with inline string which will be used as href key:

```yaml
chilldev_viewhelpers:
    stylesheets:
        - "/styles/main.css"
```

## &lt;script&gt;

`<script>` tag helper configuration allows you to define initial script references:

```yaml
chilldev_viewhelpers:
    scripts:
        -
            src: "/javascript/prototype.js" # required
            type: "text/javascript" # optional, this is default value
            flow: "default" # optional, one of "default", "defer", "async", this is default value
            charset: "utf-8" # optional
```

Like with stylesheet definitions, `<script>` can be defined with just a plain string:

```yaml
chilldev_viewhelpers:
    scripts:
        - "/javascript/prototype.js"
```

## &lt;meta&gt;

Very similar like with `<link>` helper, you can define default `<meta>` tags for your website:

```yaml
chilldev_viewhelpers:
    meta:
        -
            name: "author"
            content: "Chillout Development" # required
        -
            property: "og:title"
            content: "ChillDev ViewHelpers bundle" # required
        -
            http_equiv: "Content-Language"
            content: "pl" # required
```

**Note:** single meta definition *HAS TO* contain exacly one of `name`, `property` or `http_equiv` fields.

### Keywords

Special case of `<meta>` tag is `<meta name="keywords"/>` which comes pre-defined as phrases (strings) container. You can configure set of global keywords that will be added to this container at startup:

```yaml
chilldev_viewhelpers:
    keywords:
        - "xhtml"
        - "php"
        - "view helpers"
        - "chilldev"
        - "symfony2"
        - "bundle"
```

# Full example

```yaml
chilldev_viewhelpers:
    # <title> definition
    title:
        base: "ChillDev ViewHelpers bundle"
        separator: " :: "

    # <link>s definition
    links:
        -
            href: "http://static.chilldev.pl/images/favicon.png" # required
            rels: # required
                - "shortcut"
                - "icon"
            type: "image/png"

    # stylesheets <link>s
    stylesheets:
        -
            href: "/styles/main.css"

    # <script>s definition
    scripts:
        -
            src: "/javascript/prototype.js" # required
            type: "application/javascript"

    # <meta> tags
    meta:
        -
            name: "author"
            content: "Chillout Development" # required
        -
            property: "og:title"
            content: "ChillDev ViewHelpers bundle" # required

    # site keywords
    keywords:
        - "xhtml"
        - "php"
        - "view helpers"
        - "chilldev"
        - "symfony2"
        - "bundle"
```

Note, that `serializer` helper has no configuration.
