<?php
namespace ZeroConfig\Preacher\Generator;

use SplFileObject;
use ZeroConfig\Preacher\Output\OutputInterface;

class OutputWriter implements OutputWriterInterface
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
    public function writeOutput(OutputInterface $output, string $contents): int
    {
        $file  = new SplFileObject($output->getPath(), 'w');
        $bytes = $file->fwrite($contents);

        unset($file);

        return $bytes;
    }
}
