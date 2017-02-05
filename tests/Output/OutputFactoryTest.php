<?php
namespace ZeroConfig\Preacher\Tests\Output;

use ZeroConfig\Preacher\Output\MetaDataFactoryInterface;
use ZeroConfig\Preacher\Output\OutputFactory;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\SourceTranslatorInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\OutputFactory
 */
class OutputFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return OutputFactory
     * @covers ::__construct
     */
    public function testConstructor(): OutputFactory
    {
        /** @noinspection PhpParamsInspection */
        return new OutputFactory(
            $this->createMock(SourceTranslatorInterface::class),
            $this->createMock(MetaDataFactoryInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param OutputFactory $factory
     *
     * @return OutputInterface
     * @covers ::createOutput
     */
    public function testCreateOutput(OutputFactory $factory): OutputInterface
    {
        /** @noinspection PhpParamsInspection */
        return $factory->createOutput(
            $this->createMock(SourceInterface::class)
        );
    }
}
