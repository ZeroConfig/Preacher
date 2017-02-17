<?php
namespace ZeroConfig\Preacher\Tests\Source;

use Iterator;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\FilterInterface;
use ZeroConfig\Preacher\Source\SourceFactoryInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Source\SourceIterator;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\SourceIterator
 */
class SourceIteratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return SourceIterator
     *
     * @covers ::__construct
     */
    public function testConstructor(): SourceIterator
    {
        /** @noinspection PhpParamsInspection */
        return new SourceIterator(
            $this->createMock(Iterator::class),
            $this->createMock(SourceFactoryInterface::class)
        );
    }

    /**
     * @param bool $returnValue
     *
     * @return PHPUnit_Framework_MockObject_MockObject|FilterInterface
     */
    private function createFilter(bool $returnValue)
    {
        $filter = $this->createMock(FilterInterface::class);
        $filter
            ->expects($this->any())
            ->method('isFileAllowed')
            ->with($this->isInstanceOf(SplFileInfo::class))
            ->willReturn($returnValue);

        return $filter;
    }

    /**
     * @depends testConstructor
     *
     * @param SourceIterator $iterator
     *
     * @return SourceIterator
     * @covers ::addFilter
     */
    public function testAddFilter(SourceIterator $iterator): SourceIterator
    {
        $iterator->addFilter($this->createFilter(true));
        $iterator->addFilter($this->createFilter(false));

        return $iterator;
    }

    /**
     * @depends testAddFilter
     *
     * @param SourceIterator $iterator
     *
     * @return bool
     * @covers ::__invoke
     */
    public function testInvoke(SourceIterator $iterator): bool
    {
        /** @noinspection PhpParamsInspection */
        $returnValue = $iterator->__invoke(
            $this->createMock(SplFileInfo::class)
        );

        $this->assertFalse($returnValue);

        return $returnValue;
    }

    /**
     * @param string[] ...$files
     *
     * @return Iterator|PHPUnit_Framework_MockObject_MockObject
     */
    private function createFileIterator(string ...$files)
    {
        $iterator = $this->createMock(Iterator::class);
        $valid    = array_fill(0, count($files), true);
        $valid[]  = false;

        $iterator
            ->expects($this->exactly(count($valid)))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(...$valid);

        $iterator
            ->expects($this->exactly(count($files)))
            ->method('key')
            ->willReturnOnConsecutiveCalls(...$files);

        $iterator
            ->expects($this->exactly(count($files)))
            ->method('current')
            ->willReturn(
                $this->createMock(SplFileInfo::class)
            );

        return $iterator;
    }

    /**
     * @return SourceInterface
     * @covers ::getSources
     * @covers ::rewind
     * @covers ::valid
     * @covers ::key
     * @covers ::current
     * @covers ::next
     */
    public function testIteration(): SourceInterface
    {
        /** @noinspection PhpParamsInspection */
        $sources = iterator_to_array(
            new SourceIterator(
                $this->createFileIterator('foo', 'bar', 'baz'),
                $this->createMock(SourceFactoryInterface::class)
            )
        );

        return current($sources);
    }
}
