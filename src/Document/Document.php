<?php
namespace ZeroConfig\Preacher\Document;

use DateTimeInterface;
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

    /**
     * Get the date at which the source file was first created.
     *
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface
    {
        return $this->getSource()->getMetaData()->getDateCreated();
    }

    /**
     * Get the date at which the document was first published.
     *
     * @return DateTimeInterface
     */
    public function getDatePublished(): DateTimeInterface
    {
        return $this->getOutput()->getMetaData()->getDatePublished();
    }

    /**
     * Get the date at which the document was last generated.
     *
     * @return DateTimeInterface
     */
    public function getDateGenerated(): DateTimeInterface
    {
        return $this->getOutput()->getMetaData()->getDateGenerated();
    }

    /**
     * Get the date at which the source was last updated.
     *
     * @return DateTimeInterface
     */
    public function getDateSourceUpdated(): DateTimeInterface
    {
        return $this->getSource()->getMetaData()->getDateUpdated();
    }

    /**
     * Get the date at which the template was last updated.
     *
     * @return DateTimeInterface
     */
    public function getDateTemplateUpdated(): DateTimeInterface
    {
        return $this->getTemplate()->getDateUpdated();
    }
}
