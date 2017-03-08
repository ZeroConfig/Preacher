<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Generator\Context\ContextInterface;
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
     * @param ArrayAccess      $templateData
     * @param ContextInterface $context
     *
     * @return void
     */
    public function enrich(
        ArrayAccess $templateData,
        ContextInterface $context
    ) {
        $templateData->offsetSet(
            'content',
            $this->reader->getContents($context->getSource())
        );
    }
}
