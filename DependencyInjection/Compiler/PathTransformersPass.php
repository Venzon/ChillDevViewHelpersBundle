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

namespace ChillDev\Bundle\ViewHelpersBundle\DependencyInjection\Compiler;

use LogicException;
use ReflectionClass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass that grabs all path transformers.
 *
 * @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 * @copyright 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
 * @version 0.1.5
 * @since 0.1.5
 * @package ChillDev\Bundle\ViewHelpersBundle
 */
class PathTransformersPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     * @version 0.1.5
     * @since 0.1.5
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('chilldev.viewhelpers.path_resolver')) {
            $resolver = $container->getDefinition('chilldev.viewhelpers.path_resolver');

            // grab all path transformers
            foreach ($container->findTaggedServiceIds('chilldev.viewhelpers.path_transformer') as $id => $attributes) {
                // make sure, that service defined as path transformer implements transformer interface
                $class = $container->getDefinition($id)->getClass();
                $reflection = new ReflectionClass($class);

                if (!$reflection->implementsInterface(
                    'ChillDev\\Bundle\\ViewHelpersBundle\\PathResolver\\Transformer\\TransformerInterface'
                )) {
                    throw new LogicException(
                        sprintf(
                            'Service "%s" is defined with class "%s", which does not implements transformer interface',
                            $id,
                            $class
                        )
                    );
                }

                // one service can have multiple tags
                foreach ($attributes as $attributes) {
                    if (!isset($attributes['prefix'])) {
                        throw new LogicException(
                            sprintf(
                                '"prefix" attribute is required for tag "chilldev.viewhelpers.path_resolver" '
                                . 'for class "%s"',
                                $id
                            )
                        );
                    }

                    $repository->addMethodCall(
                        'registerTransformer',
                        array($attributes['prefix'], new Reference($id))
                    );
                }
            }
        }
    }
}
