<?php
namespace ZeroConfig\Preacher\Renderer;

use ArrayObject;
use Twig_Environment;
use ZeroConfig\Preacher\Data\DataEnricherInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

class TwigRenderer implements RendererInterface
{
    /** @var Twig_Environment */
    private $twig;

    /** @var DataEnricherInterface */
    private $enricher;

    /**
     * Constructor.
     *
     * @param Twig_Environment      $twig
     * @param DataEnricherInterface $enricher
     */
    public function __construct(
        Twig_Environment $twig,
        DataEnricherInterface $enricher
    ) {
        $this->twig     = $twig;
        $this->enricher = $enricher;
    }

    /**
     * Render the given template with the given source, for the given output.
     *
     * @param TemplateInterface $template
     * @param SourceInterface   $source
     * @param OutputInterface   $output
     *
     * @return string
     */
    public function render(
        TemplateInterface $template,
        SourceInterface $source,
        OutputInterface $output
    ): string {
        $templateData = new ArrayObject(['template' => $template]);

        $this->enricher->enrich($templateData, $source, $output);

        return $this
            ->twig
            ->render(
                $template->getPath(),
                $templateData->getArrayCopy()
            );
    }
}
