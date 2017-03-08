<?php
namespace ZeroConfig\Preacher\Generator\Context;

use ZeroConfig\Preacher\Source\SourceInterface;

interface ContextFactoryInterface
{
    /**
     * Create a context for the given source.
     *
     * @param SourceInterface $source
     *
     * @return ContextInterface
     */
    public function createContext(SourceInterface $source): ContextInterface;
}
