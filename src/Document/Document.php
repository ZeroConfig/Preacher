<?php
namespace ZeroConfig\Preacher\Document;

use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

class Document implements DocumentInterface
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
     * Mark the current document as an updated document.
     *
     * @return void
     */
    public function updateOutput()
    {
        $this->output = new UpdatedOutput($this->output);
    }
}
