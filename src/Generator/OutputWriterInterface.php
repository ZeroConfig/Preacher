<?php
namespace ZeroConfig\Preacher\Generator;

use ZeroConfig\Preacher\Output\OutputInterface;

interface OutputWriterInterface
{
    /**
     * Write the contents to the given output and return the number of bytes
     * written.
     *
     * @param OutputInterface $output
     * @param string          $contents
     *
     * @return int
     */
    public function writeOutput(OutputInterface $output, string $contents): int;
}
