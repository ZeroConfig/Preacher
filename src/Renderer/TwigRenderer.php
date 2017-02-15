<?php
namespace ZeroConfig\Preacher\Renderer;

use Twig_Environment;
use ZeroConfig\Preacher\Generator\SourceReaderInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

class TwigRenderer implements RendererInterface
{
    /** @var Twig_Environment */
    private $twig;

    /** @var HeadlineExtractorInterface */
    private $headlineExtractor;

    /** @var SourceReaderInterface */
    private $sourceReader;

    /**
     * Constructor.
     *
     * @param Twig_Environment           $twig
     * @param HeadlineExtractorInterface $headlineExtractor
     * @param SourceReaderInterface      $sourceReader
     */
    public function __construct(
        Twig_Environment $twig,
        HeadlineExtractorInterface $headlineExtractor,
        SourceReaderInterface $sourceReader
    ) {
        $this->twig              = $twig;
        $this->headlineExtractor = $headlineExtractor;
        $this->sourceReader      = $sourceReader;
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
        $content  = $this->sourceReader->getContents($source);
        $headline = $this->headlineExtractor->extractHeadline($content);

        return $this
            ->twig
            ->render(
                $template->getPath(),
                [
                    'template' => $template,
                    'source' => $source,
                    'output' => $output,
                    'content' => $content,
                    'headline' => $headline
                ]
            );
    }
}
