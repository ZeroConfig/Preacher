<?php
namespace ZeroConfig\Preacher\Tests\Source;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Source\Author;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Author
 */
class AuthorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Author
     *
     * @covers ::__construct
     */
    public function testConstructor(): Author
    {
        return new Author('Jan-Marten de Boer', 'preacher@johmanx.com');
    }

    /**
     * @depends testConstructor
     *
     * @param Author $author
     *
     * @return string
     * @covers ::getName
     */
    public function testGetName(Author $author): string
    {
        return $author->getName();
    }

    /**
     * @depends testConstructor
     *
     * @param Author $author
     *
     * @return string
     * @covers ::getEmail
     */
    public function testGetEmail(Author $author): string
    {
        return $author->getEmail();
    }
}
