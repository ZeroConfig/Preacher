<?php
namespace ZeroConfig\Preacher;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use ZeroConfig\Preacher\DependencyInjection\Compiler\SourceFilterPass;

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
    }
}
