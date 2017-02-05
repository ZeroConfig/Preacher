<?php
namespace ZeroConfig\Preacher\Tests\Source;

use ZeroConfig\Preacher\Source\MetaDataInterface;
use ZeroConfig\Preacher\Source\Source;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Source
 */
class SourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Source
     * @covers ::__construct
     */
    public function testConstructor(): Source
    {
        /** @noinspection PhpParamsInspection */
        return new Source(
            'foo',
            $this->createMock(MetaDataInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param Source $source
     *
     * @return string
     * @covers ::getPath
     */
    public function testGetPath(Source $source): string
    {
        return $source->getPath();
    }

    /**
     * @depends testConstructor
     *
     * @param Source $source
     *
     * @return MetaDataInterface
     * @covers ::getMetaData
     */
    public function testGetMetaData(Source $source): MetaDataInterface
    {
        return $source->getMetaData();
    }
}
