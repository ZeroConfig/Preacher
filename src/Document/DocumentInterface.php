<?php
namespace ZeroConfig\Preacher\Document;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

interface DocumentInterface
{
    /**
     * Get the source.
     *
     * @return SourceInterface
     */
    public function getSource(): SourceInterface;

    /**
     * Get the template.
     *
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface;

    /**
     * Get the output.
     *
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface;

    /**
     * Mark the current document as an updated document.
     *
     * @return void
     */
    public function updateOutput();
}
