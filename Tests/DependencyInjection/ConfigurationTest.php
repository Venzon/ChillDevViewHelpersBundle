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
}
