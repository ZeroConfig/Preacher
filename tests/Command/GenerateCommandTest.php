<?php
namespace ZeroConfig\Preacher\Tests\Command;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZeroConfig\Preacher\Command\GenerateCommand;
use ZeroConfig\Preacher\Generator\GeneratorInterface;
use ZeroConfig\Preacher\Output\Output;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Source\SourceIteratorInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Command\GenerateCommand
 */
class GenerateCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return GenerateCommand
     *
     * @covers ::__construct
     */
    public function testConstructor(): GenerateCommand
    {
        /** @noinspection PhpParamsInspection */
        return new GenerateCommand(
            $this->createMock(SourceIteratorInterface::class),
            $this->createMock(GeneratorInterface::class)
        );
    }

    /**
     * Create a source for the given path.
     *
     * @param string $path
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|SourceInterface
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
     * @return void
     * @covers ::execute
     * @covers ::isMatchingSource
     */
    public function testExecute()
    {
        $sources   = $this->createMock(SourceIteratorInterface::class);
        $generator = $this->createMock(GeneratorInterface::class);
        $output    = $this->createMock(OutputInterface::class);

        /** @noinspection PhpParamsInspection */
        $command = new GenerateCommand($sources, $generator);

        $output
            ->expects($this->once())
            ->method('writeln')
            ->with($this->matchesRegularExpression('/Generated/'));

        $generator
            ->expects($this->exactly(2))
            ->method('generate')
            ->with($this->isInstanceOf(SourceInterface::class))
            ->willReturnOnConsecutiveCalls(
                $this->createMock(Output::class),
                $this->createMock(UpdatedOutput::class)
            );

        $sources
            ->expects($this->exactly(3))
            ->method('current')
            ->willReturnOnConsecutiveCalls(
                $this->createSource('bar.md'),
                $this->createSource('foo.md'),
                $this->createSource('foo.md')
            );

        $sources
            ->expects($this->exactly(4))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, true, true, false);

        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('getOption')
            ->with('force')
            ->willReturn(false);

        $input
            ->expects($this->once())
            ->method('getArgument')
            ->with('source')
            ->willReturn(['foo.md']);

        /** @noinspection PhpParamsInspection */
        $command->run($input, $output);
    }
}
