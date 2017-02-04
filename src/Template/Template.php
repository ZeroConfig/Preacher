<?php
namespace ZeroConfig\Preacher\Template;

use DateTimeInterface;

class Template implements TemplateInterface
{
    /** @var string */
    private $path;

    /** @var DateTimeInterface */
    private $dateUpdated;

    /**
     * Constructor.
     *
     * @param string            $path
     * @param DateTimeInterface $dateUpdated
     */
    public function __construct(string $path, DateTimeInterface $dateUpdated)
    {
        $this->path        = $path;
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * Get the path to the template.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the date at which the template has last been updated.
     *
     * @return DateTimeInterface
     */
    public function getDateUpdated(): DateTimeInterface
    {
        return $this->dateUpdated;
    }
}
