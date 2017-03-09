<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Renderer\SourceReaderInterface;

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
     * Enrich the template data using the given context.
     *
     * @param ArrayAccess       $templateData
     * @param DocumentInterface $document
     *
     * @return void
     */
    public function enrich(
        ArrayAccess $templateData,
        DocumentInterface $document
    ) {
        $templateData->offsetSet(
            'content',
            $this->reader->getContents($document->getSource())
        );
    }
}
