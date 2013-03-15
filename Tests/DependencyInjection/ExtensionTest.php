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
use ChillDev\Bundle\ViewHelpersBundle\Templating\Script\Element as Script;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.3
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
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function enabledPaginator()
    {
        $config = [
            'paginator' => true,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertTrue($container->hasDefinition('chilldev.viewhelpers.helper.paginator'), 'ChillDevViewHelpersExtension::load() should load paginator helper if it is enabled in configuration.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function disabledPaginator()
    {
        $config = [
            'paginator' => false,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertFalse($container->hasDefinition('chilldev.viewhelpers.helper.paginator'), 'ChillDevViewHelpersExtension::load() should not load paginator helper if it is disabled in configuration.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function enabledSerializer()
    {
        $config = [
            'serializer' => true,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertTrue($container->hasDefinition('chilldev.viewhelpers.helper.serializer'), 'ChillDevViewHelpersExtension::load() should load serializer helper if it is enabled in configuration.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function disabledSerializer()
    {
        $config = [
            'serializer' => false,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertFalse($container->hasDefinition('chilldev.viewhelpers.helper.serializer'), 'ChillDevViewHelpersExtension::load() should not load serializer helper if it is disabled in configuration.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function enabledFormatter()
    {
        $config = [
            'formatter' => true,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertTrue($container->hasDefinition('chilldev.viewhelpers.helper.formatter'), 'ChillDevViewHelpersExtension::load() should load formatter helper if it is enabled in configuration.');
    }

    /**
     * @test
     * @version 0.1.3
     * @since 0.1.3
     */
    public function disabledFormatter()
    {
        $config = [
            'formatter' => false,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $this->assertFalse($container->hasDefinition('chilldev.viewhelpers.helper.formatter'), 'ChillDevViewHelpersExtension::load() should not load formatter helper if it is disabled in configuration.');
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
     * Check if links parameters are handled correctly.
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
                $this->assertEquals($href, $call[1][0], 'ChillDevViewHelpersExtension::load() should set href parameter for "chilldev.viewhelpers.helper.link"::add().');
                $this->assertEquals($rels, $call[1][1], 'ChillDevViewHelpersExtension::load() should set rels parameter for "chilldev.viewhelpers.helper.link"::add().');
                $this->assertEquals($type, $call[1][2], 'ChillDevViewHelpersExtension::load() should set type parameter for "chilldev.viewhelpers.helper.link"::add().');
                $this->assertEquals($media, $call[1][3], 'ChillDevViewHelpersExtension::load() should set media parameter for "chilldev.viewhelpers.helper.link"::add().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined links in "chilldev.viewhelpers.helper.link" service definition.');
    }

    /**
     * Check if stylesheets links parameters are handled correctly.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function preDefinedStylesheets()
    {
        $href = 'foo';
        $type = 'text/xsl';
        $media = 'screen';

        $config = [
            'stylesheets' => [
                [
                    'href' => $href,
                    'type' => $type,
                    'media' => $media,
                ],
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.link')->getMethodCalls() as $call) {
            if ($call[0] === 'addStylesheet') {
                $this->assertEquals($href, $call[1][0], 'ChillDevViewHelpersExtension::load() should set href parameter for "chilldev.viewhelpers.helper.link"::addStylesheet().');
                $this->assertEquals($media, $call[1][1], 'ChillDevViewHelpersExtension::load() should set media parameter for "chilldev.viewhelpers.helper.link"::addStylesheet().');
                $this->assertEquals($type, $call[1][2], 'ChillDevViewHelpersExtension::load() should set type parameter for "chilldev.viewhelpers.helper.link"::addStylesheet().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined stylesheets links in "chilldev.viewhelpers.helper.link" service definition.');
    }

    /**
     * Check if scripts parameters are handled correctly.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function preDefinedScripts()
    {
        $src = 'foo';

        $config = [
            'scripts' => [
                [
                    'src' => $src,
                    'flow' => 'async',
                ],
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.script')->getMethodCalls() as $call) {
            if ($call[0] === 'add') {
                $this->assertEquals($src, $call[1][0], 'ChillDevViewHelpersExtension::load() should set src parameter for "chilldev.viewhelpers.helper.script"::add().');
                $this->assertEquals(Script::TYPE_TEXTJAVASCRIPT, $call[1][1], 'ChillDevViewHelpersExtension::load() should set type parameter for "chilldev.viewhelpers.helper.script"::add().');
                $this->assertEquals(Script::FLOW_ASYNC, $call[1][2], 'ChillDevViewHelpersExtension::load() should set flow (translated to proper flag) parameter for "chilldev.viewhelpers.helper.script"::add().');
                $this->assertNull($call[1][3], 'ChillDevViewHelpersExtension::load() should set charset parameter for "chilldev.viewhelpers.helper.script"::add().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined scripts in "chilldev.viewhelpers.helper.script" service definition.');
    }

    /**
     * Check if xml namespaces parameters are handled correctly.
     *
     * @test
     * @version 0.1.0
     * @since 0.1.0
     */
    public function preDefinedXmlNamespaces()
    {
        $namespace = 'foo';
        $alias = 'bar';

        $config = [
            'xml_namespaces' => [
                $namespace => $alias,
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.xmlns')->getMethodCalls() as $call) {
            if ($call[0] === 'offsetSet') {
                $this->assertEquals($namespace, $call[1][0], 'ChillDevViewHelpersExtension::load() should set key parameter for "chilldev.viewhelpers.helper.xmlns"::offsetSet().');
                $this->assertEquals($alias, $call[1][1], 'ChillDevViewHelpersExtension::load() should set value parameter for "chilldev.viewhelpers.helper.xmlns"::offsetSet().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined xmlns="" attributes in "chilldev.viewhelpers.helper.script" service definition.');
    }

    /**
     * Check if keywords are handled correctly.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function preDefinedKeywords()
    {
        $value = ['foo', 'bar', 'baz'];

        $config = [
            'keywords' => $value,
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        foreach ($container->getDefinition('chilldev.viewhelpers.container.keywords')->getMethodCalls() as $call) {
            if ($call[0] === 'append') {
                $this->assertEquals($value, $call[1], 'ChillDevViewHelpersExtension::load() should pass all defined keywords to "chilldev.viewhelpers.container.keywords"::append().');
                return;
            }
        }

        $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined keywords in "chilldev.viewhelpers.container.keywords" service definition.');
    }

    /**
     * Check if meta parameters are handled correctly.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function preDefinedMetas()
    {
        $name = 'foo';
        $nameContent = 'bar';
        $property = 'baz';
        $propertyContent = 'qux';
        $httpEquiv = 'quux';
        $httpEquivContent = 'corge';

        $config = [
            'meta' => [
                [
                    'name' => $name,
                    'content' => $nameContent,
                ],
                [
                    'property' => $property,
                    'content' => $propertyContent,
                ],
                [
                    'http_equiv' => $httpEquiv,
                    'content' => $httpEquivContent,
                ],
            ],
        ];
        $container = new ContainerBuilder();

        $this->extension->load([$config], $container);

        $foundName = false;
        $foundProperty = false;
        $foundHttpEquiv = false;

        foreach ($container->getDefinition('chilldev.viewhelpers.helper.meta')->getMethodCalls() as $call) {
            if ($call[0] === 'setMetaName' && $call[1][0] != 'keywords') {
                $foundName = true;

                $this->assertEquals($name, $call[1][0], 'ChillDevViewHelpersExtension::load() should set meta key parameter for "chilldev.viewhelpers.helper.title"::setMetaName().');
                $this->assertEquals($nameContent, $call[1][1], 'ChillDevViewHelpersExtension::load() should set meta content parameter for "chilldev.viewhelpers.helper.title"::setMetaName().');
            } elseif ($call[0] === 'setProperty') {
                $foundProperty = true;

                $this->assertEquals($property, $call[1][0], 'ChillDevViewHelpersExtension::load() should set meta key parameter for "chilldev.viewhelpers.helper.title"::setProperty().');
                $this->assertEquals($propertyContent, $call[1][1], 'ChillDevViewHelpersExtension::load() should set meta content parameter for "chilldev.viewhelpers.helper.title"::setProperty().');
            } elseif ($call[0] === 'setHttpEquiv') {
                $foundHttpEquiv = true;

                $this->assertEquals($httpEquiv, $call[1][0], 'ChillDevViewHelpersExtension::load() should set meta key parameter for "chilldev.viewhelpers.helper.title"::setHttpEquiv().');
                $this->assertEquals($httpEquivContent, $call[1][1], 'ChillDevViewHelpersExtension::load() should set meta content parameter for "chilldev.viewhelpers.helper.title"::setHttpEquiv().');
            }
        }

        if (!$foundName) {
            $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined meta-names in "chilldev.viewhelpers.helper.meta" service definition.');
        }
        if (!$foundProperty) {
            $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined meta-properties in "chilldev.viewhelpers.helper.meta" service definition.');
        }
        if (!$foundHttpEquiv) {
            $this->fail('ChillDevViewHelpersExtension::load() should set pre-defined meta-http-equivs in "chilldev.viewhelpers.helper.meta" service definition.');
        }
    }

    /**
     * Check if XHTML is disabled by default.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function xhtmlDisabled()
    {
        $container = new ContainerBuilder();

        $this->extension->load([[]], $container);

        $this->assertFalse($container->hasDefinition('chilldev.viewhelpers.helper.xhtml'), 'ChillDevViewHelpersExtension::load() should not load XHTML helper definition by default.');
    }

    /**
     * Check if enabling XHTML causes definitions loading.
     *
     * @test
     * @version 0.0.1
     * @since 0.0.1
     */
    public function xhtmlEnabled()
    {
        $container = new ContainerBuilder();

        $this->extension->load([[
                    'xhtml' => true,
        ]], $container);

        $this->assertTrue($container->hasDefinition('chilldev.viewhelpers.helper.xhtml'), 'ChillDevViewHelpersExtension::load() should load XHTML helper on demand.');
    }
}
