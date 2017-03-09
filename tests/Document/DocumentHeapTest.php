<?php
namespace ZeroConfig\Preacher\Tests\Document;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentHeap;
use ZeroConfig\Preacher\Document\DocumentInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Document\DocumentHeap
 */
class DocumentHeapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param DateTimeInterface|null $datePublished
     *
     * @return PHPUnit_Framework_MockObject_MockObject|DocumentInterface
     */
    private function createDocument(
        DateTimeInterface $datePublished = null
    ) {
        $document = $this->createMock(DocumentInterface::class);

        if ($datePublished !== null) {
            $document
                ->expects($this->once())
                ->method('getDatePublished')
                ->willReturn($datePublished);
        }

        return $document;
    }

    /**
     * @return void
     * @covers ::compare
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCompareIllegalFirstDocument()
    {
        $heap = new DocumentHeap();
        $heap->insert('Foo');
        $heap->insert($this->createDocument());
    }

    /**
     * @return void
     * @covers ::compare
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCompareIllegalSecondDocument()
    {
        $heap = new DocumentHeap();
        $heap->insert($this->createDocument());
        $heap->insert('Foo');
    }

    /**
     * @return void
     * @covers ::compare
     */
    public function testComparison()
    {
        // Oldest.
        $documentA = $this->createDocument(new DateTimeImmutable('-2 days'));

        // Newest.
        $documentB = $this->createDocument(new DateTimeImmutable('-1 hour'));

        $heap = new DocumentHeap();

        // Oldest.
        $heap->insert($documentA);

        // Newest.
        $heap->insert($documentB);

        // Assert that the order is the opposite from what was entered.
        $heap->rewind();

        // Newest.
        $this->assertSame($documentB, $heap->current());

        $heap->next();

        // Oldest.
        $this->assertSame($documentA, $heap->current());
    }
}
