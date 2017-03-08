<?php
namespace ZeroConfig\Preacher\Generator;

use ArrayObject;
use ZeroConfig\Preacher\Data\DataEnricherInterface;
use ZeroConfig\Preacher\Generator\Context\ContextFactoryInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\RenderGuardInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Renderer\RendererInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

class Generator implements GeneratorInterface
{
    /** @var ContextFactoryInterface */
    private $contextFactory;

    /** @var RenderGuardInterface */
    private $renderGuard;

    /** @var OutputWriterInterface */
    private $outputWriter;

    /** @var RendererInterface */
    private $renderer;

    /** @var DataEnricherInterface */
    private $enricher;

    /**
     * Constructor.
     *
     * @param ContextFactoryInterface $contextFactory
     * @param RenderGuardInterface    $renderGuard
     * @param OutputWriterInterface   $outputWriter
     * @param RendererInterface       $renderer
     * @param DataEnricherInterface   $enricher
     */
    public function __construct(
        ContextFactoryInterface $contextFactory,
        RenderGuardInterface $renderGuard,
        OutputWriterInterface $outputWriter,
        RendererInterface $renderer,
        DataEnricherInterface $enricher
    ) {
        $this->contextFactory = $contextFactory;
        $this->renderGuard    = $renderGuard;
        $this->outputWriter   = $outputWriter;
        $this->renderer       = $renderer;
        $this->enricher       = $enricher;
    }

    /**
     * Generate the file for the given source and return the corresponding
     * output.
     *
     * @param SourceInterface $source
     * @param bool            $force
     *
     * @return OutputInterface
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function generate(
        SourceInterface $source,
        bool $force = false
    ): OutputInterface {
        $context = $this->contextFactory->createContext($source);

        if ($force === false
            && $this->renderGuard->isRenderRequired($context) === false
        ) {
            return $context->getOutput();
        }

        $context = $context->withUpdatedOutput();
        $output  = $context->getOutput();
        $data    = new ArrayObject();

        $this->enricher->enrich($data, $context);

        $this->outputWriter->writeOutput(
            $output,
            $this->renderer->render(
                $context->getTemplate(),
                $data->getArrayCopy()
            )
        );

        return $output;
    }
}
