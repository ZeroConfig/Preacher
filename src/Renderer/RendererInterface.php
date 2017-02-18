<?php
namespace ZeroConfig\Preacher\Renderer;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

interface RendererInterface
{
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
    ): string;
}
