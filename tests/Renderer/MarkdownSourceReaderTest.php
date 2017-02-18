<?php
namespace ZeroConfig\Preacher\Tests\Renderer;

use org\bovigo\vfs\vfsStream;
use Parsedown;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Preacher\Renderer\MarkdownSourceReader;
use ZeroConfig\Preacher\Source\SourceInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Renderer\MarkdownSourceReader
 */
class MarkdownSourceReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Parsedown|PHPUnit_Framework_MockObject_MockObject
     */
    private function createParserPassThrough()
    {
        $parser = $this->createMock(Parsedown::class);

        $parser
            ->expects($this->any())
            ->method('text')
            ->with($this->isType('string'))
            ->willReturnArgument(0);

        return $parser;
    }

    /**
     * @return MarkdownSourceReader
     * @covers ::__construct
     */
    public function testConstructor(): \ZeroConfig\Preacher\Renderer\MarkdownSourceReader
    {
        return new MarkdownSourceReader(
            $this->createParserPassThrough()
        );
    }

    /**
     * @param string $path
     *
     * @return PHPUnit_Framework_MockObject_MockObject|SourceInterface
     */
    private function createSource(string $path)
    {
        $source = $this->createMock(SourceInterface::class);

        $source
            ->expects($this->once())
            ->method('getPath')
            ->willReturn($path);

        return $source;
    }

    /**
     * @depends testConstructor
     *
     * @param \ZeroConfig\Preacher\Renderer\MarkdownSourceReader $reader
     *
     * @return void
     * @covers ::getContents
     */
    public function testGetContents(MarkdownSourceReader $reader)
    {
        $root = vfsStream::setup(
            sha1(__FILE__),
            0444,
            [
                'source.md' => 'Foo bar baz'
            ]
        );

        $source = $this->createSource(
            $root->getChild('source.md')->url()
        );

        $this->assertEquals('Foo bar baz', $reader->getContents($source));
    }
}
