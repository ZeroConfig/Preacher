<?php
namespace ZeroConfig\Preacher\Tests\Output;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Output\MetaData;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\MetaData
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
        return new MetaData(
            new DateTimeImmutable(),
            new DateTimeImmutable()
        );
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return DateTimeInterface
     * @covers ::getDatePublished
     */
    public function testGetDatePublished(MetaData $metaData): DateTimeInterface
    {
        return $metaData->getDatePublished();
    }

    /**
     * @depends testConstructor
     *
     * @param MetaData $metaData
     *
     * @return DateTimeInterface
     * @covers ::getDateGenerated
     */
    public function testGetDateGenerated(MetaData $metaData): DateTimeInterface
    {
        return $metaData->getDateGenerated();
    }
}
