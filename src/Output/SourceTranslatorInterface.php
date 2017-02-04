<?php
namespace ZeroConfig\Preacher\Output;

use ZeroConfig\Preacher\Source\SourceInterface;

interface SourceTranslatorInterface
{
    /**
     * Get the path to the output file name for the given source.
     *
     * @param SourceInterface $source
     *
     * @return string
     */
    public function getOutputPath(SourceInterface $source): string;
}
