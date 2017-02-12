<?php
namespace ZeroConfig\Preacher\Generator;

use DateTimeImmutable;
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

    /** @var HeadlineExtractorInterface */
    private $headlineExtractor;

    /**
     * Constructor.
     *
     * @param OutputFactoryInterface     $outputFactory
     * @param TemplateFactoryInterface   $templateFactory
     * @param SourceReaderInterface      $sourceReader
     * @param Twig_Environment           $templateEngine
     * @param OutputWriterInterface      $outputWriter
     * @param HeadlineExtractorInterface $headlineExtractor
     */
    public function __construct(
        OutputFactoryInterface $outputFactory,
        TemplateFactoryInterface $templateFactory,
        SourceReaderInterface $sourceReader,
        Twig_Environment $templateEngine,
        OutputWriterInterface $outputWriter,
        HeadlineExtractorInterface $headlineExtractor
    ) {
        $this->outputFactory     = $outputFactory;
        $this->templateFactory   = $templateFactory;
        $this->sourceReader      = $sourceReader;
        $this->templateEngine    = $templateEngine;
        $this->outputWriter      = $outputWriter;
        $this->headlineExtractor = $headlineExtractor;
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
        $content  = $this->sourceReader->getContents($source);
        $headline = $this->headlineExtractor->extractHeadline($content);

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
                        'content' => $content,
                        'headline' => $headline
                    ]
                )
        );

        return $output;
    }
}
