<?php
namespace ZeroConfig\Preacher\Source;

class CommitReference implements CommitReferenceInterface
{
    /** @var string */
    private $full;

    /** @var string */
    private $short;

    /**
     * Constructor.
     *
     * @param string $full
     * @param string $short
     */
    public function __construct(string $full, string $short)
    {
        $this->full  = $full;
        $this->short = $short;
    }

    /**
     * Get the short commit reference.
     *
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * Get the full commit reference.
     *
     * @return string
     */
    public function getFull(): string
    {
        return $this->full;
    }

    /**
     * Convert the reference to a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFull();
    }
}
