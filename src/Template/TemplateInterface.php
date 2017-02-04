<?php
namespace ZeroConfig\Preacher\Template;

use DateTimeInterface;

interface TemplateInterface
{
    /**
     * Get the path to the template.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get the date at which the template has last been updated.
     *
     * @return DateTimeInterface
     */
    public function getDateUpdated(): DateTimeInterface;
}
