<?php
namespace ZeroConfig\Preacher\Output;

interface MetaDataFactoryInterface
{
    /**
     * Create meta data for the given output path.
     *
     * @param string $path
     *
     * @return MetaDataInterface
     */
    public function createMetaData(string $path): MetaDataInterface;
}
