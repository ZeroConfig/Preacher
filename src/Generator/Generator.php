<?php
namespace ZeroConfig\Preacher\Generator;

use Twig_Environment;
use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;

class Generator implements GeneratorInterface
{
    /** @var OutputFactoryInterface */
    private $outputFactory;

    /** @var TemplateFactoryInterface */
    private $templateFactory;

    /** @var SourceReaderInterface */
    private $sourceReader;

    /** @var Twig_Environment */
    private $templateEngine;

    /** @var OutputWriterInterface */
    private $outputWriter;

    /**
     * Constructor.
     *
     * @param OutputFactoryInterface   $outputFactory
     * @param TemplateFactoryInterface $templateFactory
     * @param SourceReaderInterface    $sourceReader
     * @param Twig_Environment         $templateEngine
     * @param OutputWriterInterface    $outputWriter
     */
    public function __construct(
        OutputFactoryInterface $outputFactory,
        TemplateFactoryInterface $templateFactory,
        SourceReaderInterface $sourceReader,
        Twig_Environment $templateEngine,
        OutputWriterInterface $outputWriter
    ) {
        $this->outputFactory   = $outputFactory;
        $this->templateFactory = $templateFactory;
        $this->sourceReader    = $sourceReader;
        $this->templateEngine  = $templateEngine;
        $this->outputWriter    = $outputWriter;
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
        $generated = $output->getMetaData()->getDateGenerated();
        $updated   = $source->getMetaData()->getDateUpdated();

        // No changes since last generation.
        if ($generated > $updated) {
            return $output;
        }

        $output   = new UpdatedOutput($output);
        $template = $this->templateFactory->createTemplate($output);

        $this->outputWriter->writeOutput(
            $output,
            $this
                ->templateEngine
                ->render(
                    $template->getPath(),
                    [
                        'template' => $template,
                        'source' => $source,
                        'output' => $output,
                        'content' => $this->sourceReader->getContents($source)
                    ]
                )
        );

        return $output;
    }
}
