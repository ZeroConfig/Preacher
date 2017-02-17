<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SourceFilterPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('preacher.source_iterator')) {
            return;
        }

        $definition = $container->getDefinition('preacher.source_iterator');
        $services   = array_keys(
            $container->findTaggedServiceIds('preacher.source_filter')
        );

        foreach ($services as $service) {
            $definition->addMethodCall(
                'addFilter',
                [new Reference($service)]
            );
        }
    }
}
