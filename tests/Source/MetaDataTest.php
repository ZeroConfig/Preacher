<?php
namespace ZeroConfig\Preacher\Tests\Source;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Source\AuthorInterface;
use ZeroConfig\Preacher\Source\CommitReferenceInterface;
use ZeroConfig\Preacher\Source\MetaData;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\MetaData
 */
class MetaDataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return MetaData
     *
     * @covers ::__construct
     */
    public function testConstructor(): MetaData
    {
        /** @noinspection PhpParamsInspection */
        return new MetaData(
            $this->createMock(CommitReferenceInterface::class),
            $this->createMock(AuthorInterface::class),
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            1337
        );
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return AuthorInterface
     * @covers ::getAuthor
     */
    public function testGetAuthor(MetaData $metaData): AuthorInterface
    {
        return $metaData->getAuthor();
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return CommitReferenceInterface
     * @covers ::getVersion
     */
    public function testGetVersion(MetaData $metaData): CommitReferenceInterface
    {
        return $metaData->getVersion();
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return DateTimeInterface
     * @covers ::getDateCreated
     */
    public function testGetDateCreated(MetaData $metaData): DateTimeInterface
    {
        return $metaData->getDateCreated();
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return DateTimeInterface
     * @covers ::getDateUpdated
     */
    public function testGetDateUpdated(MetaData $metaData): DateTimeInterface
    {
        return $metaData->getDateUpdated();
    }

    /**
     * @depends clone testConstructor
     *
     * @param MetaData $metaData
     *
     * @return DateTimeInterface
     * @covers ::setDateUpdated
     */
    public function testSetDateUpdated(MetaData $metaData): DateTimeInterface
    {
        $metaData->setDateUpdated(new DateTimeImmutable());

        return $metaData->getDateUpdated();
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return int
     * @covers ::getNumRevisions
     */
    public function testGetNumRevisions(MetaData $metaData): int
    {
        return $metaData->getNumRevisions();
    }
}
