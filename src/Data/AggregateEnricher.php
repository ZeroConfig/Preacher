<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Document\DocumentInterface;

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
     * @param ArrayAccess       $templateData
     * @param DocumentInterface $document
     *
     * @return void
     */
    public function enrich(
        ArrayAccess $templateData,
        DocumentInterface $document
    ) {
        foreach ($this->enrichers as $enricher) {
            $enricher->enrich($templateData, $document);
        }
    }
}
