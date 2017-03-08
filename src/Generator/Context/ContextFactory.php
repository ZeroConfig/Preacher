<?php
namespace ZeroConfig\Preacher\Generator\Context;

use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;

class ContextFactory implements ContextFactoryInterface
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
     * @return ContextInterface
     */
    public function createContext(SourceInterface $source): ContextInterface
    {
        $output   = $this->outputFactory->createOutput($source);
        $template = $this->templateFactory->createTemplate($output);

        return new Context($source, $output, $template);
    }
}
