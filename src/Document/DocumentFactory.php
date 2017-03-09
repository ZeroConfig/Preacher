<?php
namespace ZeroConfig\Preacher\Document;

use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;

class DocumentFactory implements DocumentFactoryInterface
{
    /** @var OutputFactoryInterface */
    private $outputFactory;

    /** @var TemplateFactoryInterface */
    private $templateFactory;

    /**
     * Constructor.
     *
     * @param OutputFactoryInterface   $outputFactory
     * @param TemplateFactoryInterface $templateFactory
     */
    public function __construct(
        OutputFactoryInterface $outputFactory,
        TemplateFactoryInterface $templateFactory
    ) {
        $this->outputFactory   = $outputFactory;
        $this->templateFactory = $templateFactory;
    }

    /**
     * Create a context for the given source.
     *
     * @param SourceInterface $source
     *
     * @return DocumentInterface
     */
    public function createDocument(SourceInterface $source): DocumentInterface
    {
        $output   = $this->outputFactory->createOutput($source);
        $template = $this->templateFactory->createTemplate($output);

        return new Document($source, $output, $template);
    }
}
