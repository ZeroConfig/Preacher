<?php
namespace ZeroConfig\Preacher\Generator;

use ArrayObject;
use ZeroConfig\Preacher\Data\DataEnricherInterface;
use ZeroConfig\Preacher\Document\DocumentFactoryInterface;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\RenderGuardInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Renderer\RendererInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

class Generator implements GeneratorInterface
{
    /** @var OutputWriterInterface */
    private $outputWriter;

    /** @var RendererInterface */
    private $renderer;

    /** @var DataEnricherInterface */
    private $enricher;

    /**
     * Constructor.
     *
     * @param OutputWriterInterface $outputWriter
     * @param RendererInterface     $renderer
     * @param DataEnricherInterface $enricher
     */
    public function __construct(
        OutputWriterInterface $outputWriter,
        RendererInterface $renderer,
        DataEnricherInterface $enricher
    ) {
        $this->outputWriter = $outputWriter;
        $this->renderer     = $renderer;
        $this->enricher     = $enricher;
    }

    /**
     * Generate the file for the given document.
     *
     * @param DocumentInterface $document
     *
     * @return void
     */
    public function generate(DocumentInterface $document)
    {
        // Ensure the generator makes the output be marked as updated.
        $document->updateOutput();

        $data = new ArrayObject();
        $this->enricher->enrich($data, $document);

        $this->outputWriter->writeOutput(
            $document->getOutput(),
            $this->renderer->render(
                $document->getTemplate(),
                $data->getArrayCopy()
            )
        );
    }
}
