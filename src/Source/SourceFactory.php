<?php
namespace ZeroConfig\Preacher\Source;

class SourceFactory implements SourceFactoryInterface
{
    /** @var MetaDataFactoryInterface */
    private $metaDataFactory;
    /** @var string */
    private $workingDirectory;

    /**
     * Constructor.
     *
     * @param MetaDataFactoryInterface $metaDataFactory
     * @param string                   $workingDirectory
     */
    public function __construct(
        MetaDataFactoryInterface $metaDataFactory,
        string $workingDirectory
    ) {
        $this->metaDataFactory  = $metaDataFactory;
        $this->workingDirectory = $workingDirectory;
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
        $relativePath = ltrim(
            preg_replace(
                sprintf('/^%s/', preg_quote($this->workingDirectory, '/')),
                '',
                $path
            ),
            DIRECTORY_SEPARATOR
        );

        return new MarkdownSource(
            $relativePath,
            $this->metaDataFactory->createMetaData($relativePath)
        );
    }
}
