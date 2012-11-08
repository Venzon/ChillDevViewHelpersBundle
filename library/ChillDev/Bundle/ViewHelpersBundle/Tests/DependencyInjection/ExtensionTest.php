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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.0.1
 * @since 0.0.1
 * @package ChillDevViewHelpersBundle
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
}
