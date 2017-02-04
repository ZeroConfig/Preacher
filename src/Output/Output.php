<?php
namespace ZeroConfig\Preacher\Output;

class Output implements OutputInterface
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
    public function __construct(string $path, MetaDataInterface $metaData)
    {
        $this->path     = $path;
        $this->metaData = $metaData;
    }

    /**
     * Get the path to the output file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the meta data for the output file.
     *
     * @return MetaDataInterface
     */
    public function getMetaData(): MetaDataInterface
    {
        return $this->metaData;
    }
}
