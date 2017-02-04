<?php
namespace ZeroConfig\Preacher\Output;

interface OutputInterface
{
    /**
     * Get the path to the output file.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get the meta data for the output file.
     *
     * @return MetaDataInterface
     */
    public function getMetaData(): MetaDataInterface;
}
