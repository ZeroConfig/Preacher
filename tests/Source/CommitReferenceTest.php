<?php
namespace ZeroConfig\Preacher\Tests\Source;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Source\CommitReference;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\CommitReference
 */
class CommitReferenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return CommitReference
     *
     * @covers ::__construct
     */
    public function testConstructor(): CommitReference
    {
        return new CommitReference('foobarbaz', 'foobar');
    }

    /**
     * @depends testConstructor
     *
     * @param CommitReference $reference
     *
     * @return string
     * @covers ::getFull
     */
    public function testGetFull(CommitReference $reference): string
    {
        return $reference->getFull();
    }

    /**
     * @depends testConstructor
     *
     * @param CommitReference $reference
     *
     * @return string
     * @covers ::getShort
     */
    public function testGetShort(CommitReference $reference): string
    {
        return $reference->getShort();
    }

    /**
     * @depends testConstructor
     *
     * @param CommitReference $reference
     *
     * @return string
     * @covers ::__toString
     */
    public function testGetAsString(CommitReference $reference): string
    {
        return $reference->__toString();
    }
}
