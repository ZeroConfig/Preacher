<?php
namespace ZeroConfig\Preacher\Tests\Output;

use ZeroConfig\Preacher\Output\MarkdownSourceTranslator;
use ZeroConfig\Preacher\Source\SourceInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\MarkdownSourceTranslator
 */
class MarkdownSourceTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return MarkdownSourceTranslator
     * @covers ::__construct
     */
    public function testConstructor(): MarkdownSourceTranslator
    {
        return new MarkdownSourceTranslator();
    }

    /**
     * @depends testConstructor
     *
     * @param MarkdownSourceTranslator $translator
     *
     * @return string
     * @covers ::getOutputPath
     */
    public function testGetOutputPath(
        MarkdownSourceTranslator $translator
    ): string {
        $source = $this->createMock(SourceInterface::class);

        $source
            ->expects($this->once())
            ->method('getPath')
            ->willReturn('foo');

        /** @noinspection PhpParamsInspection */
        return $translator->getOutputPath($source);
    }
}
