<?php
namespace ZeroConfig\Preacher\Tests\Document;

use DateTimeImmutable;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentFactoryInterface;
use ZeroConfig\Preacher\Document\DocumentFeed;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Source\SourceIteratorInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Document\DocumentFeed
 */
class DocumentFeedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param SourceInterface[] ...$sources
     *
     * @return SourceIteratorInterface
     */
    private function createSourceIterator(
        SourceInterface ...$sources
    ): SourceIteratorInterface {
        /** @var SourceIteratorInterface|PHPUnit_Framework_MockObject_MockObject $iterator */
        $iterator = $this->createMock(SourceIteratorInterface::class);
        $valid    = array_fill(0, count($sources), true);
        $valid[]  = false;

        $iterator
            ->expects($this->exactly(count($valid)))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(...$valid);

        $iterator
            ->expects($this->exactly(count($sources)))
            ->method('current')
            ->willReturnOnConsecutiveCalls(...$sources);

        return $iterator;
    }

    /**
     * @return SourceInterface
     */
    private function createSource(): SourceInterface
    {
        /** @var SourceInterface $source */
        $source = $this->createMock(SourceInterface::class);

        return $source;
    }

    /**
     * @return void
     * @covers ::__construct
     * @covers ::getDocuments
     * @covers ::next
     * @covers ::key
     * @covers ::valid
     * @covers ::rewind
     * @covers ::current
     */
    public function testFeed()
    {
        /** @var DocumentFactoryInterface|PHPUnit_Framework_MockObject_MockObject $factory */
        $factory = $this->createMock(DocumentFactoryInterface::class);

        $feed = new DocumentFeed(
            $this->createSourceIterator(
                $this->createSource(),
                $this->createSource(),
                $this->createSource()
            ),
            $factory
        );

        $factory
            ->expects($this->exactly(3))
            ->method('createDocument')
            ->with($this->isInstanceOf(SourceInterface::class))
            ->willReturnCallback(
                function () : DocumentInterface {
                    static $offset = 0;

                    /** @var DocumentInterface|PHPUnit_Framework_MockObject_MockObject $document */
                    $document = $this->createMock(DocumentInterface::class);

                    $document
                        ->expects($this->atLeastOnce())
                        ->method('getDatePublished')
                        ->willReturn(
                            new DateTimeImmutable(
                                sprintf('+%d seconds', ++$offset)
                            )
                        );

                    return $document;
                }
            );

        $numDocuments = 0;

        foreach ($feed as $offset => $document) {
            $this->assertInternalType('integer', $offset);
            $this->assertInstanceOf(DocumentInterface::class, $document);
            $numDocuments++;
        }

        $this->assertEquals(3, $numDocuments);
    }
}
