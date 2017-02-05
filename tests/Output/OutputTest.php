<?php
namespace ZeroConfig\Preacher\Tests\Output;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Output\MetaDataInterface;
use ZeroConfig\Preacher\Output\Output;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\Output
 */
class OutputTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Output
     *
     * @covers ::__construct
     */
    public function testConstructor(): Output
    {
        /** @noinspection PhpParamsInspection */
        return new Output(
            'foo',
            $this->createMock(MetaDataInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param Output $output
     *
     * @return string
     * @covers ::getPath
     */
    public function testGetPath(Output $output): string
    {
        return $output->getPath();
    }

    /**
     * @depends testConstructor
     *
     * @param Output $output
     *
     * @return MetaDataInterface
     * @covers ::getMetaData
     */
    public function testGetMetaData(Output $output): MetaDataInterface
    {
        return $output->getMetaData();
    }
}
