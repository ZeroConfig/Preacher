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
     * @return AbstractSource
     * @covers ::__construct
     */
    public function testConstructor(): AbstractSource
    {
        $fileName = 'foo.md';
        $metaData = $this->createMock(MetaDataInterface::class);

        $source = new class($fileName, $metaData) extends AbstractSource
        {
            /**
             * Extract the basename from the given path.
             *
             * @param string $path
             *
             * @return string
             */
            protected function extractBaseName(string $path): string
            {
                return basename($path, '.md');
            }
        };

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
