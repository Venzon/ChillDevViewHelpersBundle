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

`&lt;title&gt;` tag helper configuration provides two properties - `base` which is the default first element of page title (if not defined initial title will be empty) and `separator` which defines the string which will be used to glue all the parts together when displaying.

```yaml
chilldev_viewhelpers:
    title:
        base: "ChillDev ViewHelpers bundle"
        separator: " :: " # defaults to " - "
```

## &lt;link&gt;

`&lt;link&gt;` tag helper configuration allows you to define initial references that will be applied to helper on each site:

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

Most common use of `&lt;link&gt;` element is to define external stylesheets. You can use `stylesheets` key for shorter notation - it requires only `href` key, `type` is by default of value *text/css* and `rel` is always *stylesheet*:

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

`&lt;script&gt;` tag helper configuration allows you to define initial script references:

```yaml
chilldev_viewhelpers:
    scripts:
        -
            src: "/javascript/prototype.js" # required
            type: "text/javascript" # optional, this is default value
            flow: "default" # optional, one of "default", "defer", "async", this is default value
            charset: "utf-8" # optional
```

Like with stylesheet definitions, `&lt;script&gt;` can be defined with just a plain string:

```yaml
chilldev_viewhelpers:
    scripts:
        - "/javascript/prototype.js"
```

## xmlns=""

You can also define XML namespaces in bundle configuration with simple map:

```yaml
chilldev_viewhelpers:
    xml_namespaces:
        http://www.w3.org/1999/xhtml: ""
        http://ogp.me/ns/fb#: "fb"
```

## &lt;meta&gt;

Very similar like with `&lt;link&gt;` and `&lt;script&gt;` helpers, you can define default `&lt;meta&gt;` tags for your website:

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

Special case of `&lt;meta&gt;` tag is `&lt;meta name="keywords"/&gt;` which comes pre-defined as phrases (strings) container. You can configure set of global keywords that will be added to this container at startup:

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
    # &lt;title&gt; definition
    title:
        base: "ChillDev ViewHelpers bundle"
        separator: " :: "

    # &lt;link&gt;s definition
    links:
        -
            href: "http://static.chilldev.pl/images/favicon.png" # required
            rels: # required
                - "shortcut"
                - "icon"
            type: "image/png"

    # stylesheets &lt;link&gt;s
    stylesheets:
        -
            href: "/styles/main.css"

    # &lt;script&gt;s definition
    scripts:
        -
            src: "/javascript/prototype.js" # required
            type: "application/javascript"

    # &lt;meta&gt; tags
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
