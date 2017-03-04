<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

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
     * Enrich the template data using the given source and output.
     *
     * @param ArrayAccess     $templateData
     * @param SourceInterface $source
     * @param OutputInterface $output
     *
     * @return void
     */
    public function enrich(
        ArrayAccess $templateData,
        SourceInterface $source,
        OutputInterface $output
    ) {
        foreach ($this->enrichers as $enricher) {
            $enricher->enrich($templateData, $source, $output);
        }
    }
}
