<?php
namespace ZeroConfig\Preacher\Tests\Source;

use ZeroConfig\Preacher\Source\MetaDataInterface;
use ZeroConfig\Preacher\Source\AbstractSource;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\AbstractSource
 */
class AbstractSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AbstractSource
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $source = $this->getMockForAbstractClass(
            AbstractSource::class,
            [
                'foo.md',
                $this->createMock(MetaDataInterface::class)
            ]
        );

        $source
            ->expects($this->any())
            ->method('extractBaseName')
            ->with($this->isType('string'))
            ->willReturnCallback(
                function (string $path) : string {
                    return basename($path, '.md');
                }
            );

        return $source;
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
     * @return string
     * @covers ::getBaseName
     */
    public function testGetBaseName(AbstractSource $source): string
    {
        return $source->getBaseName();
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
