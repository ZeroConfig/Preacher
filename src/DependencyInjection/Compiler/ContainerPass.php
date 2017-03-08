<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Throwable;

class ContainerPass implements CompilerPassInterface
{
    /** @var string */
    private $containerIdentifier;

    /** @var string */
    private $tagName;

    /** @var string */
    private $methodName;

    /**
     * Constructor.
     *
     * @param string $containerIdentifier
     * @param string $tagName
     * @param string $methodName
     */
    public function __construct($containerIdentifier, $tagName, $methodName)
    {
        $this->containerIdentifier = $containerIdentifier;
        $this->tagName             = $tagName;
        $this->methodName          = $methodName;
    }

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
                $this->containerIdentifier
            );
        } catch (Throwable $e) {
            return;
        }

        $services = array_keys(
            $container->findTaggedServiceIds($this->tagName)
        );

        foreach ($services as $service) {
            $definition->addMethodCall(
                $this->methodName,
                [new Reference($service)]
            );
        }
    }
}
