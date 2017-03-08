<?php
namespace ZeroConfig\Preacher\Renderer;

use ZeroConfig\Preacher\Template\TemplateInterface;

interface RendererInterface
{
    /**
     * Render the given template using the given data.
     *
     * @param TemplateInterface $template
     * @param array             $data
     *
     * @return string
     */
    public function render(TemplateInterface $template, array $data): string;
}
