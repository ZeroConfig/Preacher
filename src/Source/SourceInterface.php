<?php
namespace ZeroConfig\Preacher\Source;

interface SourceInterface
{
    /**
     * Get the path to the source file.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get the basename of the file, without extension.
     *
     * @return string
     */
    public function getBaseName(): string;

    /**
     * Get the meta data for the source.
     *
     * @return MetaDataInterface
     */
    public function getMetaData(): MetaDataInterface;
}
