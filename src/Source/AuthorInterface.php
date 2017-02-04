<?php
namespace ZeroConfig\Preacher\Source;

interface AuthorInterface
{
    /**
     * Get the name of the author.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the email of the author.
     *
     * @return string
     */
    public function getEmail(): string;
}
