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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class ExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ChillDevViewHelpersExtension
     * @version 0.0.1
     * @since 0.0.1
     */
    protected $extension;

    /**
     * @version 0.0.1
     * @since 0.0.1
     */
    protected function setUp()
    {
        $this->extension = new ChillDevViewHelpersExtension();
    }

    /**
     * Check if title.separator parameter is handled correctly.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function titleSeparatorParameter()
    {
        $separator = '!';

        $config = [
            'title' => [
                'separator' => $separator,
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);
        $this->assertEquals($separator, $container->getParameter('chilldev.viewhelpers.title.separator'), 'ChillDevViewHelpersExtension::load() should set "chilldev.viewhelpers.title.separator" parameter to separator value.');
    }

    /**
     * Check if title.base parameter is handled correctly.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function titleBaseParameter()
    {
        $value = 'foo';

        $config = [
            'title' => [
                'base' => $value,
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.title')->getMethodCalls() as $call) {
            if ($call[0] === 'append' && $call[1][0] === $value) {
                $this->assertTrue(true, 'This is to get rid of incomplete test because of lack of assertions.');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should append base title to "chilldev.viewhelpers.helper.title" service definition.');
    }

    /**
     * Check if links parameters is handled correctly.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function preDefinedLinks()
    {
        $href = 'foo';
        $rels = ['bar', 'baz'];
        $type = 'text/css';
        $media = 'screen';

        $config = [
            'links' => [
                [
                    'href' => $href,
                    'rels' => $rels,
                    'type' => $type,
                    'media' => $media,
                ],
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.link')->getMethodCalls() as $call) {
            if ($call[0] === 'add') {
                $this->assertEquals($href, $call[1][0], 'ChillDevViewHelpersExtension::load() should set href parameter for "chilldev.viewhelpers.helper.title"::add().');
                $this->assertEquals($rels, $call[1][1], 'ChillDevViewHelpersExtension::load() should set rels parameter for "chilldev.viewhelpers.helper.title"::add().');
                $this->assertEquals($type, $call[1][2], 'ChillDevViewHelpersExtension::load() should set type parameter for "chilldev.viewhelpers.helper.title"::add().');
                $this->assertEquals($media, $call[1][3], 'ChillDevViewHelpersExtension::load() should set media parameter for "chilldev.viewhelpers.helper.title"::add().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined links in "chilldev.viewhelpers.helper.link" service definition.');
    }
}
