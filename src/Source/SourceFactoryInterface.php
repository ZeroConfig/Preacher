<?php
namespace ZeroConfig\Preacher\Source;

interface SourceFactoryInterface
{
    /**
     * Create a source for the given file path.
     *
     * @param string $path
     *
     * @return SourceInterface
     */
    public function createSource(string $path): SourceInterface;
}
