<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Throwable;

abstract class AbstractContainerPass implements CompilerPassInterface
{
    /**
     * Get the service identifier for the container service.
     *
     * @return string
     */
    abstract public function getContainerIdentifier(): string;

    /**
     * Get the tag name that identifies child services.
     *
     * @return string
     */
    abstract public function getTagName(): string;

    /**
     * Get the method name which applies the service to the container.
     *
     * @return string
     */
    abstract public function getMethodName(): string;

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        try {
            $definition = $container->getDefinition(
                $this->getContainerIdentifier()
            );
        } catch (Throwable $e) {
            return;
        }

        $method   = $this->getMethodName();
        $services = array_keys(
            $container->findTaggedServiceIds(
                $this->getTagName()
            )
        );

        foreach ($services as $service) {
            $definition->addMethodCall(
                $method,
                [new Reference($service)]
            );
        }
    }
}
