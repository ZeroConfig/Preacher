<?php
namespace ZeroConfig\Preacher\Tests\Generator;

use org\bovigo\vfs\vfsStream;
use ZeroConfig\Preacher\Generator\OutputWriter;
use ZeroConfig\Preacher\Output\OutputInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\OutputWriter
 */
class OutputWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return int
     * @covers ::writeOutput
     */
    public function testWriteOutput(): int
    {
        $writer = new OutputWriter();
        $root   = vfsStream::setup(
            sha1(__FILE__),
            0444,
            [
                'output.html' => ''
            ]
        );

        $output = $this->createMock(OutputInterface::class);

        $output
            ->expects($this->once())
            ->method('getPath')
            ->willReturn(
                $root->getChild('output.html')->url()
            );

        /** @noinspection PhpParamsInspection */
        return $writer->writeOutput($output, 'Foo');
    }
}
