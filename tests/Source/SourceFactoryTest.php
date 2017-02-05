<?php
namespace ZeroConfig\Preacher\Tests\Source;

use ZeroConfig\Preacher\Source\MetaDataFactoryInterface;
use ZeroConfig\Preacher\Source\SourceFactory;
use ZeroConfig\Preacher\Source\SourceInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\SourceFactory
 */
class SourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SourceFactory
     * @covers ::__construct
     */
    public function testConstructor(): SourceFactory
    {
        /** @noinspection PhpParamsInspection */
        return new SourceFactory(
            $this->createMock(MetaDataFactoryInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param SourceFactory $factory
     *
     * @return SourceInterface
     * @covers ::createSource
     */
    public function testCreateSource(SourceFactory $factory): SourceInterface
    {
        return $factory->createSource('foo');
    }
}
