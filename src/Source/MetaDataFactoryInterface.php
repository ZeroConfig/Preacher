<?php
namespace ZeroConfig\Preacher\Source;

interface MetaDataFactoryInterface
{
    /**
     * Create a meta data instance for the given relative file name.
     *
     * @param string $file
     *
     * @return MetaDataInterface
     */
    public function createMetaData(string $file): MetaDataInterface;
}
