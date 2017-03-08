<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Generator\Context\ContextInterface;

class ContextEnricher implements DataEnricherInterface
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
    ) {
        $templateData->offsetSet('template', $context->getTemplate());
        $templateData->offsetSet('source', $context->getSource());
        $templateData->offsetSet('output', $context->getOutput());
    }
}
