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
     * @return void
     * @covers ::execute
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
            ->expects($this->exactly(2))
            ->method('current')
            ->willReturn(
                $this->createMock(SourceInterface::class)
            );

        $sources
            ->expects($this->exactly(3))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, true, false);

        /** @noinspection PhpParamsInspection */
        $command->run(
            $this->createMock(InputInterface::class),
            $output
        );
    }
}
