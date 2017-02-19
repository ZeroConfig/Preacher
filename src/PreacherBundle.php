<?php
namespace ZeroConfig\Preacher;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use ZeroConfig\Preacher\DependencyInjection\Compiler\SourceFilterPass;
use ZeroConfig\Preacher\DependencyInjection\Compiler\TwigExtensionPass;

/**
 * @codeCoverageIgnore
 */
class PreacherBundle extends Bundle
{
    /**
     * Add compiler passes.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SourceFilterPass());
        $container->addCompilerPass(new TwigExtensionPass());
    }
}
