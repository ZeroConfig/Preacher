<?php
namespace ZeroConfig\Preacher\Source;

class Author implements AuthorInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $email
     */
    public function __construct(string $name, string $email)
    {
        $this->name  = $name;
        $this->email = $email;
    }

    /**
     * Get the name of the author.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the email of the author.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
