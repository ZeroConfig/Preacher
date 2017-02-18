<?php
namespace ZeroConfig\Preacher\Generator;

use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Renderer\RendererInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;

class Generator implements GeneratorInterface
{
    /** @var OutputFactoryInterface */
    private $outputFactory;

    /** @var TemplateFactoryInterface */
    private $templateFactory;

    /** @var OutputWriterInterface */
    private $outputWriter;

    /** @var RendererInterface */
    private $renderer;

    /**
     * Constructor.
     *
     * @param OutputFactoryInterface   $outputFactory
     * @param TemplateFactoryInterface $templateFactory
     * @param OutputWriterInterface    $outputWriter
     * @param RendererInterface        $renderer
     */
    public function __construct(
        OutputFactoryInterface $outputFactory,
        TemplateFactoryInterface $templateFactory,
        OutputWriterInterface $outputWriter,
        RendererInterface $renderer
    ) {
        $this->outputFactory   = $outputFactory;
        $this->templateFactory = $templateFactory;
        $this->outputWriter    = $outputWriter;
        $this->renderer        = $renderer;
    }

    /**
     * Generate the file for the given source and return the corresponding
     * output.
     *
     * @param SourceInterface $source
     *
     * @return OutputInterface
     */
    public function generate(SourceInterface $source): OutputInterface
    {
        $output    = $this->outputFactory->createOutput($source);
        $published = $output->getMetaData()->getDatePublished();
        $generated = $output->getMetaData()->getDateGenerated();
        $updated   = $source->getMetaData()->getDateUpdated();
        $template  = $this->templateFactory->createTemplate($output);

        // No changes since last generation.
        // Check that it at least has an initial generation, previous to this.
        if ($generated > $published
            && $generated > $updated
            && $generated > $template->getDateUpdated()
        ) {
            return $output;
        }

        $output   = new UpdatedOutput($output);

        $this->outputWriter->writeOutput(
            $output,
            $this->renderer->render($template, $source, $output)
        );

        return $output;
    }
}
