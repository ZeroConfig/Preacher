<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

interface DataEnricherInterface
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
    );
}
