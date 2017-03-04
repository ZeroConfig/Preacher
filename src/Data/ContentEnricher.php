<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Renderer\SourceReaderInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

class ContentEnricher implements DataEnricherInterface
{
    /** @var SourceReaderInterface */
    private $reader;

    /**
     * Constructor.
     *
     * @param SourceReaderInterface $reader
     */
    public function __construct(SourceReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Enrich the template data using the given source and output.
     *
     * @param ArrayAccess     $templateData
     * @param SourceInterface $source
     * @param OutputInterface $output
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function enrich(
        ArrayAccess $templateData,
        SourceInterface $source,
        OutputInterface $output
    ) {
        $templateData->offsetSet(
            'content',
            $this->reader->getContents($source)
        );
    }
}
