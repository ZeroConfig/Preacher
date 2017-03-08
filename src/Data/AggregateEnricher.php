<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Generator\Context\ContextInterface;

class AggregateEnricher implements DataEnricherInterface
{
    /**
     * @var DataEnricherInterface[]
     */
    private $enrichers = [];

    /**
     * Add an enricher to the aggregate.
     *
     * @param DataEnricherInterface $enricher
     *
     * @return void
     */
    public function addEnricher(DataEnricherInterface $enricher)
    {
        $this->enrichers[spl_object_hash($enricher)] = $enricher;
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
        foreach ($this->enrichers as $enricher) {
            $enricher->enrich($templateData, $context);
        }
    }
}
