<?php
namespace ZeroConfig\Preacher\Output;

use ZeroConfig\Preacher\Source\SourceInterface;

interface OutputFactoryInterface
{
    /**
     * Create an output entity for the given source.
     *
     * @param SourceInterface $source
     *
     * @return OutputInterface
     */
    public function createOutput(SourceInterface $source): OutputInterface;
}
