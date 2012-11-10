<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\ChillDevViewHelpersExtension;
use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\Configuration;

use Symfony\Component\Config\Definition\NodeInterface;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
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
}
