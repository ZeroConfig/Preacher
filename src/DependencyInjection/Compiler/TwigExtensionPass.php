<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TwigExtensionPass implements CompilerPassInterface
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
        if (!$container->hasDefinition('preacher.twig')) {
            return;
        }

        $twig       = $container->getDefinition('preacher.twig');
        $extensions = array_keys(
            $container->findTaggedServiceIds('preacher.twig_extension')
        );

        foreach ($extensions as $extension) {
            $twig->addMethodCall(
                'addExtension',
                [new Reference($extension)]
            );
        }
    }
}
