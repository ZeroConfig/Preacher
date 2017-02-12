<?php
namespace ZeroConfig\Preacher\Tests\Source;

use ZeroConfig\Preacher\Source\MetaDataInterface;
use ZeroConfig\Preacher\Source\AbstractSource;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Source
 */
class SourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return AbstractSource
     * @covers ::__construct
     */
    public function testConstructor(): AbstractSource
    {
        /** @noinspection PhpParamsInspection */
        return new AbstractSource(
            'foo',
            $this->createMock(MetaDataInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param AbstractSource $source
     *
     * @return string
     * @covers ::getPath
     */
    public function testGetPath(AbstractSource $source): string
    {
        return $source->getPath();
    }

    /**
     * @depends testConstructor
     *
     * @param AbstractSource $source
     *
     * @return MetaDataInterface
     * @covers ::getMetaData
     */
    public function testGetMetaData(AbstractSource $source): MetaDataInterface
    {
        return $source->getMetaData();
    }
}
