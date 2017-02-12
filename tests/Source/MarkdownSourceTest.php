<?php
namespace ZeroConfig\Preacher\Tests\Source;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Source\MarkdownSource;
use ZeroConfig\Preacher\Source\MetaDataInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\MarkdownSource
 */
class MarkdownSourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     *
     * @covers ::extractBaseName
     */
    public function testExtractBaseName()
    {
        /** @var MetaDataInterface $metaData */
        $metaData = $this->createMock(MetaDataInterface::class);
        $source   = new MarkdownSource('foo.md', $metaData);

        $this->assertEquals('foo', $source->getBaseName());
    }
}
