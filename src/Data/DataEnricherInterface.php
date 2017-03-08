<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Generator\Context\ContextInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

interface DataEnricherInterface
{
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
    );
}
