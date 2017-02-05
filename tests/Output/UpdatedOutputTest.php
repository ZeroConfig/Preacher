<?php
namespace ZeroConfig\Preacher\Tests\Output;

use DateTimeImmutable;
use DateTimeInterface;
use ZeroConfig\Preacher\Output\MetaDataInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\UpdatedOutput
 */
class UpdatedOutputTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string            $path
     * @param DateTimeInterface $datePublished
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|OutputInterface
     */
    private function createOutput(
        string $path,
        DateTimeInterface $datePublished
    ) {
        $output   = $this->createMock(OutputInterface::class);
        $metaData = $this->createMock(MetaDataInterface::class);

        $metaData
            ->expects($this->any())
            ->method('getDatePublished')
            ->willReturn($datePublished);

        $output
            ->expects($this->any())
            ->method('getPath')
            ->willReturn($path);

        $output
            ->expects($this->any())
            ->method('getMetaData')
            ->willReturn($metaData);

        return $output;
    }

    /**
     * @return UpdatedOutput
     * @covers ::__construct
     */
    public function testConstructor(): UpdatedOutput
    {
        return new UpdatedOutput(
            $this->createOutput('foo', new DateTimeImmutable())
        );
    }

    /**
     * @depends testConstructor
     *
     * @param UpdatedOutput $output
     *
     * @return string
     * @covers ::getPath
     */
    public function testGetPath(UpdatedOutput $output): string
    {
        return $output->getPath();
    }

    /**
     * @depends testConstructor
     *
     * @param UpdatedOutput $output
     *
     * @return MetaDataInterface
     * @covers ::getMetaData
     */
    public function testGetMetaData(UpdatedOutput $output): MetaDataInterface
    {
        return $output->getMetaData();
    }
}
