<?php
namespace ZeroConfig\Preacher\Generator\Context;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

class Context implements ContextInterface
{
    /** @var SourceInterface */
    private $source;

    /** @var OutputInterface */
    private $output;

    /** @var TemplateInterface */
    private $template;

    /**
     * Constructor.
     *
     * @param SourceInterface   $source
     * @param OutputInterface   $output
     * @param TemplateInterface $template
     */
    public function __construct(
        SourceInterface $source,
        OutputInterface $output,
        TemplateInterface $template
    ) {
        $this->source   = $source;
        $this->output   = $output;
        $this->template = $template;
    }

    /**
     * Get the source.
     *
     * @return SourceInterface
     */
    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    /**
     * Get the template.
     *
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        return $this->template;
    }

    /**
     * Get the output.
     *
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * Get the same context with updated output.
     *
     * @return ContextInterface
     */
    public function withUpdatedOutput(): ContextInterface
    {
        $context = clone $this;
        $context->output = new UpdatedOutput($this->output);
        return $context;
    }
}
