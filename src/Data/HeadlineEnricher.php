<?php
namespace ZeroConfig\Preacher\Data;

use ArrayAccess;
use ZeroConfig\Preacher\Generator\Context\ContextInterface;
use ZeroConfig\Preacher\Renderer\HeadlineExtractorInterface;

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
     * Enrich the template data using the given context.
     *
     * @param ArrayAccess      $templateData
     * @param ContextInterface $context
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function enrich(
        ArrayAccess $templateData,
        ContextInterface $context
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
