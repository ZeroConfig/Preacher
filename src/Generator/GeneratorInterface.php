<?php
namespace ZeroConfig\Preacher\Generator;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

interface GeneratorInterface
{
    /**
     * Generate the file for the given source and return the corresponding
     * output.
     *
     * @param SourceInterface $source
     *
     * @return OutputInterface
     */
    public function generate(SourceInterface $source): OutputInterface;
}
