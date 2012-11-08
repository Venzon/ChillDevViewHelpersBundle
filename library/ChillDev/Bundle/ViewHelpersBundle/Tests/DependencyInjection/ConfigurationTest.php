<?php

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\ChillDevViewHelpersExtension;
use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\Configuration;

use \Symfony\Component\Config\Definition\NodeInterface;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
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
}
