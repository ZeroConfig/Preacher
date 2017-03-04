<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @codeCoverageIgnore
 */
class SourceFilterPass extends AbstractContainerPass
{
    /**
     * Get the service identifier for the container service.
     *
     * @return string
     */
    public function getContainerIdentifier(): string
    {
        return 'preacher.source_iterator';
    }

    /**
     * Get the tag name that identifies child services.
     *
     * @return string
     */
    public function getTagName(): string
    {
        return 'preacher.source_filter';
    }

    /**
     * Get the method name which applies the service to the container.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'addFilter';
    }
}
