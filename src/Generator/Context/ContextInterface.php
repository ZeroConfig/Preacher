<?php
namespace ZeroConfig\Preacher\Generator\Context;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

interface ContextInterface
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
     * Get the same context with updated output.
     *
     * @return ContextInterface
     */
    public function withUpdatedOutput(): ContextInterface;
}
