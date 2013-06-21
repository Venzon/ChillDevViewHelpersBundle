<?php

/**
 * This file is part of the ChillDev ViewHelpers bundle.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */

namespace ChillDev\Bundle\ViewHelpersBundle\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_TestCase;

use ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\Compiler\PathTransformersPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class PathTransformersPassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @version 0.1.5
     * @since 0.1.5
     */
    public function process()
    {
        $resolver = new Definition();

        $container = new ContainerBuilder();
        $container->setDefinition('chilldev.viewhelpers.path_resolver', $resolver);

        $definition = new Definition('ChillDev\\Bundle\\ViewHelpersBundle\\PathResolver\\Transformer\\CustomTransformer');
        $definition->addTag('chilldev.viewhelpers.path_transformer', ['prefix' => 'bar']);
        $definition->addTag('chilldev.viewhelpers.path_transformer', ['prefix' => 'baz']);
        $container->setDefinition('foo', $definition);

        (new PathTransformersPass())->process($container);

        // perform checks on processed definition
        $calls = $resolver->getMethodCalls();
        $this->assertCount(2, $calls, 'PathTransformerPass::process() should add call for each prefix tag.');

        for ($i = 0; $i < 2; ++$i) {
            $this->assertEquals('registerTransformer', $calls[$i][0], 'PathTransformerPass::process() should register calls to PathResolver::registerTransformer().');
            $this->assertEquals('foo', $calls[$i][1][1]->__toString(), 'PathTransformerPass::process() should register calls with transformer definition reference passed.');
        }
    }

    /**
     * @test
     * @expectedException LogicException
     * @expectedExceptionMessage Service "foo" is defined with class "stdClass", which does not implements transformer interface.
     * @version 0.1.5
     * @since 0.1.5
     */
    public function processWithInvalidInterface()
    {
        $container = new ContainerBuilder();
        $container->setDefinition('chilldev.viewhelpers.path_resolver', new Definition());

        $definition = new Definition('stdClass');
        $definition->addTag('chilldev.viewhelpers.path_transformer');
        $container->setDefinition('foo', $definition);

        (new PathTransformersPass())->process($container);
    }

    /**
     * @test
     * @expectedException LogicException
     * @expectedExceptionMessage "prefix" attribute is required for tag "chilldev.viewhelpers.path_resolver" for class "foo".
     * @version 0.1.5
     * @since 0.1.5
     */
    public function processWithoutPrefix()
    {
        $container = new ContainerBuilder();
        $container->setDefinition('chilldev.viewhelpers.path_resolver', new Definition());

        $definition = new Definition('ChillDev\\Bundle\\ViewHelpersBundle\\PathResolver\\Transformer\\CustomTransformer');
        $definition->addTag('chilldev.viewhelpers.path_transformer');
        $container->setDefinition('foo', $definition);

        (new PathTransformersPass())->process($container);
    }
}
