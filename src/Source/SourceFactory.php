<?php
namespace ZeroConfig\Preacher\Source;

class SourceFactory implements SourceFactoryInterface
{
    /** @var MetaDataFactoryInterface */
    private $metaDataFactory;

    /**
     * Constructor.
     *
     * @param MetaDataFactoryInterface $metaDataFactory
     */
    public function __construct(MetaDataFactoryInterface $metaDataFactory)
    {
        $this->metaDataFactory = $metaDataFactory;
    }

    /**
     * Create a source for the given file path.
     *
     * @param string $path
     *
     * @return SourceInterface
     */
    public function createSource(string $path): SourceInterface
    {
        return new MarkdownSource(
            $path,
            $this->metaDataFactory->createMetaData($path)
        );
    }
}
