<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\ChillDevViewHelpersExtension;
use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\Configuration;
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element;

use Symfony\Component\Config\Definition\NodeInterface;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NodeInterface
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $tree;

    /**
     * @version 0.0.1
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->tree = (new Configuration())->getConfigTreeBuilder()->buildTree();
    }

    /**
     * Check if root node name matches extension alias.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function rootNodeName()
    {
        $extension = new ChillDevViewHelpersExtension();

        $this->assertEquals($extension->getAlias(), $this->tree->getName(), 'Configuretion::getConfigTreeBuilder() should return node matching bundle\'s extension alias.');
    }

    /**
     * Check how <title> helper configuration is handled.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function handleTitleConfiguration()
    {
        $separator = '!';
        $base = 'foo';

        $config = $this->tree->finalize($this->tree->normalize([
                    'title' => [
                        'separator' => '!',
                        'base' => 'foo',
                    ],
        ]));

        $this->assertEquals($separator, $config['title']['separator'], 'Configuration should handle key title.separator.');
        $this->assertEquals($base, $config['title']['base'], 'Configuration should handle key title.base.');
    }

    /**
     * Check default <title> helper configuration.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultTitleConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([]));

        $this->assertNull($config['title']['separator'], 'Default value for title.separator should be NULL.');
        $this->assertNull($config['title']['base'], 'Default value for title.base should be NULL.');
    }

    /**
     * Check multiple <link> elements handling.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function multipleLinksDefinition()
    {
        $href1 = 'foo';
        $rel1 = 'bar';
        $href2 = 'baz';
        $rel2 = 'qux';

        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => $href1,
                            'rels' => [
                                $rel1,
                            ],
                        ],
                        [
                            'href' => $href2,
                            'rels' => [
                                $rel2,
                            ],
                        ],
                    ],
        ]));

        $this->assertEquals($href1, $config['links'][0]['href'], 'Configuration should handle key links.$n.href for each link definition.');
        $this->assertEquals($rel1, $config['links'][0]['rels'][0], 'Configuration should handle key links.$n.rels for each link definition.');
        $this->assertEquals($href2, $config['links'][1]['href'], 'Configuration should handle key links.$n.href for each link definition.');
        $this->assertEquals($rel2, $config['links'][1]['rels'][0], 'Configuration should handle key links.$n.rels for each link definition.');
    }

    /**
     * Check optional <link> element properties handling.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function optionalLinkProperties()
    {
        $type = 'foo';
        $media = 'bar';

        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => 'baz',
                            'rels' => [
                                'qux',
                            ],
                            'type' => $type,
                            'media' => $media,
                        ],
                    ],
        ]));

        $this->assertEquals($type, $config['links'][0]['type'], 'Configuration should handle key links.$n.type for link definition.');
        $this->assertEquals($media, $config['links'][0]['media'], 'Configuration should handle key links.$n.media for link definition.');
    }

    /**
     * Check requirement constraint on "href" property of <link> element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "href" at path "chilldev_viewhelpers.links.0" must be configured.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function requiredLinkHref()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'rels' => [
                                'foo',
                            ],
                        ],
                    ],
        ]));
    }

    /**
     * Check requirement constraint on "rels" property of <link> element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "rels" at path "chilldev_viewhelpers.links.0" must be configured.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function requiredLinkRels()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => 'foo',
                        ],
                    ],
        ]));
    }

    /**
     * Check non-empty constraint on "rels" property of <link> element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "chilldev_viewhelpers.links.0.rels" should have at least 1 element(s) defined.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function atLeastOneElementLinkRels()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => 'foo',
                            'rels' => [],
                        ],
                    ],
        ]));
    }

    /**
     * Check string-to-array conversion for "rels" property of <link> element definition.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function convertStringToArrayLinkRels()
    {
        $rel = 'foo';

        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => 'bar',
                            'rels' => $rel,
                        ],
                    ],
        ]));

        $this->assertEquals($rel, $config['links'][0]['rels'][0], 'Configuration should put string value as single array element of links.$n.links.');
    }

    /**
     * Check default <link> helper configuration.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultLinkConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'links' => [
                        [
                            'href' => '',
                            'rels' => [
                                'foo',
                            ],
                        ],
                    ],
        ]));

        $this->assertNull($config['links'][0]['type'], 'Default value for links.$n.type should be NULL.');
        $this->assertNull($config['links'][0]['media'], 'Default value for links.$n.media should be NULL.');
    }

    /**
     * Check multiple <link> stylesheets elements handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function multipleStylesheetsDefinition()
    {
        $href1 = 'foo';
        $href2 = 'baz';

        $config = $this->tree->finalize($this->tree->normalize([
                    'stylesheets' => [
                        [
                            'href' => $href1,
                        ],
                        [
                            'href' => $href2,
                        ],
                    ],
        ]));

        $this->assertEquals($href1, $config['stylesheets'][0]['href'], 'Configuration should handle key stylesheets.$n.href for each link definition.');
        $this->assertEquals($href2, $config['stylesheets'][1]['href'], 'Configuration should handle key stylesheets.$n.href for each link definition.');
    }

    /**
     * Check optional <link> stylesheet element properties handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function optionalStylesheetsProperties()
    {
        $type = 'foo';
        $media = 'bar';

        $config = $this->tree->finalize($this->tree->normalize([
                    'stylesheets' => [
                        [
                            'href' => 'baz',
                            'type' => $type,
                            'media' => $media,
                        ],
                    ],
        ]));

        $this->assertEquals($type, $config['stylesheets'][0]['type'], 'Configuration should handle key stylesheets.$n.type for link definition.');
        $this->assertEquals($media, $config['stylesheets'][0]['media'], 'Configuration should handle key stylesheets.$n.media for link definition.');
    }

    /**
     * Check requirement constraint on "href" property of <link> stylesheet element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "href" at path "chilldev_viewhelpers.stylesheets.0" must be configured.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function requiredStylesheetHref()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'stylesheets' => [
                        [
                        ],
                    ],
        ]));
    }

    /**
     * Check default <link> helper configuration for stylesheet.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function defaultStylesheetConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'stylesheets' => [
                        [
                            'href' => '',
                        ],
                    ],
        ]));

        $this->assertEquals('text/css', $config['stylesheets'][0]['type'], 'Default value for stylesheets.$n.type should be "text/css".');
        $this->assertNull($config['stylesheets'][0]['media'], 'Default value for stylesheets.$n.media should be NULL.');
    }

    /**
     * Check inline stylesheet handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function inlineStylesheetConfiguration()
    {
        $href = 'foo';

        $config = $this->tree->finalize($this->tree->normalize([
                    'stylesheets' => [
                        $href,
                    ],
        ]));

        $this->assertEquals($href, $config['stylesheets'][0]['href'], 'Scalar string should be converted to href of new stylesheet definition.');
        $this->assertEquals('text/css', $config['stylesheets'][0]['type'], 'Stylesheet definition created from scalar string should get default type.');
        $this->assertNull($config['stylesheets'][0]['media'], 'Stylesheet definition created from scalar string should not get any media query.');
    }

    /**
     * Check multiple <script> stylesheets elements handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function multipleScriptsDefinition()
    {
        $src1 = 'foo';
        $src2 = 'baz';

        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        [
                            'src' => $src1,
                        ],
                        [
                            'src' => $src2,
                        ],
                    ],
        ]));

        $this->assertEquals($src1, $config['scripts'][0]['src'], 'Configuration should handle key scripts.$n.src for each script definition.');
        $this->assertEquals($src2, $config['scripts'][1]['src'], 'Configuration should handle key scripts.$n.src for each script definition.');
    }

    /**
     * Check optional <script> element properties handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function optionalScriptsProperties()
    {
        $type = 'foo';
        $flow = 'defer';
        $charset = 'bar';

        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        [
                            'src' => 'baz',
                            'type' => $type,
                            'flow' => $flow,
                            'charset' => $charset,
                        ],
                    ],
        ]));

        $this->assertEquals($type, $config['scripts'][0]['type'], 'Configuration should handle key scripts.$n.type for script definition.');
        $this->assertEquals($flow, $config['scripts'][0]['flow'], 'Configuration should handle key scripts.$n.media for script definition.');
        $this->assertEquals($charset, $config['scripts'][0]['charset'], 'Configuration should handle key scripts.$n.charset for script definition.');
    }

    /**
     * Check value constraint on "flow" property of <script> element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The value "bar" is not allowed for path "chilldev_viewhelpers.scripts.0.flow". Permissible values: "default", "defer", "async"
     * @version 0.1.0
     * @since 0.1.0
     */
    public function enumScriptFlow()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        [
                            'src' => 'foo',
                            'flow' => 'bar',
                        ],
                    ],
        ]));
    }

    /**
     * Check requirement constraint on "src" property of <script> element definition.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "src" at path "chilldev_viewhelpers.scripts.0" must be configured.
     * @version 0.1.0
     * @since 0.1.0
     */
    public function requiredScriptSrc()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        [
                        ],
                    ],
        ]));
    }

    /**
     * Check default <script> helper configuration.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function defaultScriptConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        [
                            'src' => '',
                        ],
                    ],
        ]));

        $this->assertEquals(Element::TYPE_TEXTJAVASCRIPT, $config['scripts'][0]['type'], 'Default value for scripts.$n.type should be "text/javascript".');
        $this->assertEquals('default', $config['scripts'][0]['flow'], 'Default value for scripts.$n.flow should be "default".');
        $this->assertNull($config['scripts'][0]['charset'], 'Default value for scripts.$n.charset should be NULL.');
    }

    /**
     * Check inline <script> handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function inlineScriptConfiguration()
    {
        $src = 'foo';

        $config = $this->tree->finalize($this->tree->normalize([
                    'scripts' => [
                        $src,
                    ],
        ]));

        $this->assertEquals($src, $config['scripts'][0]['src'], 'Scalar string should be converted to src of new script definition.');
        $this->assertEquals(Element::TYPE_TEXTJAVASCRIPT, $config['scripts'][0]['type'], 'Script definition created from scalar string should get default type.');
        $this->assertEquals('default', $config['scripts'][0]['flow'], 'Script definition created from scalar string should get default flow.');
        $this->assertNull($config['scripts'][0]['charset'], 'Script definition created from scalar string should not get any charset query.');
    }

    /**
     * Check multiple xmlns="" definitions handling.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function multipleXmlNamespacesDefinition()
    {
        $namespace1 = 'foo';
        $prefix1 = 'bar';
        $namespace2 = 'baz';
        $prefix2 = 'qux';

        $config = $this->tree->finalize($this->tree->normalize([
                    'xml_namespaces' => [
                        $namespace1 => $prefix1,
                        $namespace2 => $prefix2,
                    ],
        ]));

        $this->assertArrayHasKey($namespace1, $config['xml_namespaces'], 'Configuration should handle each xmlns definition.');
        $this->assertArrayHasKey($namespace2, $config['xml_namespaces'], 'Configuration should handle each xmlns definition.');
        $this->assertEquals($prefix1, $config['xml_namespaces'][$namespace1], 'Configuration should handle key xml_namespaces.' . $namespace1 . ' for xmlns definition.');
        $this->assertEquals($prefix2, $config['xml_namespaces'][$namespace2], 'Configuration should handle key xml_namespaces.' . $namespace2 . ' for xmlns definition.');
    }

    /**
     * Check keywords elements handling.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function keywordsDefinition()
    {
        $keywords = ['foo', 'bar'];

        $config = $this->tree->finalize($this->tree->normalize([
                    'keywords' => $keywords,
        ]));

        $this->assertEquals($keywords, $config['keywords'], 'Configuration should handle keywords.');
    }

    /**
     * Check if configuration detects incorrectly defined meta with conflicting key values.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid configuration for path "chilldev_viewhelpers.meta.0": <meta> may have only one of "name", "property" and "http-equiv" attributes defined.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function conflictingMetaKeysDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'name' => 'foo',
                            'property' => 'bar',
                            'content' => '',
                        ],
                    ],
        ]));
    }

    /**
     * Check if configuration detects incorrectly defined meta without key values.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid configuration for path "chilldev_viewhelpers.meta.0": <meta> must have one of "name", "property" and "http-equiv" attributes defined.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function missingMetaKeyDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'content' => '',
                        ],
                    ],
        ]));
    }

    /**
     * Check if configuration detects incorrectly defined meta without content.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "content" at path "chilldev_viewhelpers.meta.0" must be configured.
     * @version 0.0.1
     * @since 0.0.1
     */
    public function missingMetaContentDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'name' => 'foo',
                        ],
                    ],
        ]));
    }

    /**
     * Check if configuration detects incorrectly defined meta with empty name key.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "chilldev_viewhelpers.meta.0.name" cannot contain an empty value, but got "".
     * @version 0.0.1
     * @since 0.0.1
     */
    public function emptyMetaNameDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'name' => '',
                            'content' => 'foo',
                        ],
                    ],
        ]));
    }

    /**
     * Check if configuration detects incorrectly defined meta with empty property key.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "chilldev_viewhelpers.meta.0.property" cannot contain an empty value, but got "".
     * @version 0.0.1
     * @since 0.0.1
     */
    public function emptyMetaPropertyDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'property' => '',
                            'content' => 'foo',
                        ],
                    ],
        ]));
    }

    /**
     * Check if configuration detects incorrectly defined meta with empty http-equiv key.
     *
     * @test
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The path "chilldev_viewhelpers.meta.0.http_equiv" cannot contain an empty value, but got "".
     * @version 0.0.1
     * @since 0.0.1
     */
    public function emptyMetaHttpEquivDefinition()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'http_equiv' => '',
                            'content' => 'foo',
                        ],
                    ],
        ]));
    }

    /**
     * Check string-to-array conversion for "rels" property of <link> element definition.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function multipleMetaDefinitions()
    {
        $meta1 = 'foo';
        $value1 = 'bar';
        $meta2 = 'baz';
        $value2 = 'qux';
        $meta3 = 'quux';
        $value3 = 'corge';

        $config = $this->tree->finalize($this->tree->normalize([
                    'meta' => [
                        [
                            'name' => $meta1,
                            'content' => $value1,
                        ],
                        [
                            'property' => $meta2,
                            'content' => $value2,
                        ],
                        [
                            'http_equiv' => $meta3,
                            'content' => $value3,
                        ],
                    ],
        ]));

        $this->assertEquals($meta1, $config['meta'][0]['name'], 'Configuration should put defined meta name key into meta.$n.name.');
        $this->assertEquals($value1, $config['meta'][0]['content'], 'Configuration should put defined meta content into meta.$n.content.');
        $this->assertEquals($meta2, $config['meta'][1]['property'], 'Configuration should put defined meta property key into meta.$n.property.');
        $this->assertEquals($value2, $config['meta'][1]['content'], 'Configuration should put defined meta content into meta.$n.content.');
        $this->assertEquals($meta3, $config['meta'][2]['http_equiv'], 'Configuration should put defined meta HTTP-equiv key into meta.$n.http_equiv.');
        $this->assertEquals($value3, $config['meta'][2]['content'], 'Configuration should put defined meta content into meta.$n.content.');
    }

    /**
     * Check default XHTML helper configuration.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function defaultXhtmlConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([]));

        $this->assertFalse($config['xhtml'], 'Default value for xhtml should be FALSE.');
    }

    /**
     * Check XHTML helper configuration handling.
     *
     * @test
     * @version 0.1.1
     * @since 0.1.1
     */
    public function xhtmlConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'xhtml' => true,
        ]));

        $this->assertTrue($config['xhtml'], 'Configuration should handle XHTML configuration flag.');
    }

    /**
     * Check default paginator helper configuration.
     *
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function defaultPaginatorConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([]));

        $this->assertTrue($config['paginator'], 'Default value for paginator should be TRUE.');
    }

    /**
     * Check paginator helper configuration handling.
     *
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function paginatorConfiguration()
    {
        $config = $this->tree->finalize($this->tree->normalize([
                    'paginator' => false,
        ]));

        $this->assertFalse($config['paginator'], 'Configuration should handle paginator configuration flag.');
    }
}
