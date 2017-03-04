<?php
namespace ZeroConfig\Preacher\Source;

abstract class AbstractSource implements SourceInterface
{
    /** @var string */
    private $path;

    /** @var string */
    private $baseName;

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
        $this->baseName = $this->extractBaseName($path);
        $this->metaData = $metaData;
    }

    /**
     * Extract the basename from the given path.
     *
     * @param string $path
     *
     * @return string
     */
    abstract protected function extractBaseName(string $path): string;

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
     * Get the basename of the file, without extension.
     *
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->baseName;
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
