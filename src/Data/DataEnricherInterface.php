<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

interface DataEnricherInterface
{
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
    );
}
