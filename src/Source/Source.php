<?php
namespace ZeroConfig\Preacher\Source;

class Source implements SourceInterface
{
    /** @var string */
    private $path;

    /** @var MetaDataInterface */
    private $metaData;

    /**
     * Constructor.
     *
     * @param string            $path
     * @param MetaDataInterface $metaData
     */
    public function __construct($path, MetaDataInterface $metaData)
    {
        $this->path     = $path;
        $this->metaData = $metaData;
    }

    /**
     * Get the path to the source file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the meta data for the source.
     *
     * @return MetaDataInterface
     */
    public function getMetaData(): MetaDataInterface
    {
        return $this->metaData;
    }
}
