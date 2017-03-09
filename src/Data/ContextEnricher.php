<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Document\DocumentInterface;

class ContextEnricher implements DataEnricherInterface
{
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
        $templateData->offsetSet('template', $document->getTemplate());
        $templateData->offsetSet('source', $document->getSource());
        $templateData->offsetSet('output', $document->getOutput());
    }
}
