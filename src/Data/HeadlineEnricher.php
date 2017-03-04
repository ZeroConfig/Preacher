<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Renderer\HeadlineExtractorInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

class HeadlineEnricher implements DataEnricherInterface
{
    /** @var HeadlineExtractorInterface */
    private $extractor;

    /**
     * Constructor.
     *
     * @param HeadlineExtractorInterface $extractor
     */
    public function __construct(HeadlineExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * Enrich the template data using the given source and output.
     *
     * @param ArrayAccess     $templateData
     * @param SourceInterface $source
     * @param OutputInterface $output
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function enrich(
        ArrayAccess $templateData,
        SourceInterface $source,
        OutputInterface $output
    ) {
        $headline = '';

        if ($templateData->offsetExists('content')) {
            $headline = $this->extractor->extractHeadline(
                $templateData->offsetGet('content')
            );
        }

        $templateData->offsetSet('headline', $headline);
    }
}
