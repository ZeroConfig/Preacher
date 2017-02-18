<?php
namespace ZeroConfig\Preacher\Renderer;

use ZeroConfig\Preacher\Source\SourceInterface;

interface SourceReaderInterface
{
    /**
     * Get the contents of the given source.
     *
     * @param SourceInterface $source
     *
     * @return string
     */
    public function getContents(SourceInterface $source): string;
}
