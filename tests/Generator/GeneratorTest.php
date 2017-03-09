<?php
namespace ZeroConfig\Preacher\Tests\Generator;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Data\DataEnricherInterface;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Generator\Generator;
use ZeroConfig\Preacher\Generator\OutputWriterInterface;
use ZeroConfig\Preacher\Renderer\RendererInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\Generator
 */
class GeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Generator
     *
     * @covers ::__construct
     */
    public function testConstructor(): Generator
    {
        /** @noinspection PhpParamsInspection */
        return new Generator(
            $this->createMock(OutputWriterInterface::class),
            $this->createMock(RendererInterface::class),
            $this->createMock(DataEnricherInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param Generator $generator
     *
     * @return void
     */
    public function testGenerate(Generator $generator)
    {
        /** @var DocumentInterface|PHPUnit_Framework_MockObject_MockObject $document */
        $document = $this->createMock(DocumentInterface::class);
        $document
            ->expects($this->once())
            ->method('updateOutput');

        $generator->generate($document);
    }
}
