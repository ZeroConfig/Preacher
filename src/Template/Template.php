<?php
namespace ZeroConfig\Preacher\Template;

class Template implements TemplateInterface
{
    /** @var string */
    private $path;

    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
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
}
