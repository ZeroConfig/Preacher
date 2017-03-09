<?php
namespace ZeroConfig\Preacher\Document;

use DateTimeInterface;
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

    /**
     * Get the date at which the source file was first created.
     *
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface;

    /**
     * Get the date at which the document was first published.
     *
     * @return DateTimeInterface
     */
    public function getDatePublished(): DateTimeInterface;

    /**
     * Get the date at which the document was last generated.
     *
     * @return DateTimeInterface
     */
    public function getDateGenerated(): DateTimeInterface;

    /**
     * Get the date at which the source was last updated.
     *
     * @return DateTimeInterface
     */
    public function getDateSourceUpdated(): DateTimeInterface;

    /**
     * Get the date at which the template was last updated.
     *
     * @return DateTimeInterface
     */
    public function getDateTemplateUpdated(): DateTimeInterface;
}
