<?php
namespace ZeroConfig\Preacher\DependencyInjection\Compiler;

class TwigExtensionPass extends AbstractContainerPass
{
    /**
     * Get the service identifier for the container service.
     *
     * @return string
     */
    public function getContainerIdentifier(): string
    {
        return 'preacher.twig';
    }

    /**
     * Get the tag name that identifies child services.
     *
     * @return string
     */
    public function getTagName(): string
    {
        return 'preacher.twig_extension';
    }

    /**
     * Get the method name which applies the service to the container.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return 'addExtension';
    }
}
