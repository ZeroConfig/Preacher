<?php
namespace ZeroConfig\Preacher\Source;

interface CommitReferenceInterface
{
    /**
     * Get the short commit reference.
     *
     * @return string
     */
    public function getShort(): string;

    /**
     * Get the full commit reference.
     *
     * @return string
     */
    public function getFull(): string;

    /**
     * Convert the reference to a string.
     *
     * @return string
     */
    public function __toString(): string;
}
