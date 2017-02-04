<?php
namespace ZeroConfig\Preacher\Template;

interface TemplateInterface
{
    /**
     * Get the path to the template.
     *
     * @return string
     */
    public function getPath(): string;
}
