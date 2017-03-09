<?php
namespace ZeroConfig\Preacher\Tests\Data;

use ArrayAccess;
use ArrayObject;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Preacher\Data\AggregateEnricher;
use ZeroConfig\Preacher\Data\DataEnricherInterface;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Data\AggregateEnricher
 */
class AggregateEnricherTest extends AbstractDataEnricherTestCase
{
    /**
     * @return void
     * @covers ::enrich
     */
    public function testEnrichWithEmptyAggregate()
    {
        $enricher = new AggregateEnricher();
        $data     = new ArrayObject();

        $enricher->enrich($data, $this->createDocument());

        $this->assertEmpty($data);
    }

    /**
     * @return void
     * @covers ::addEnricher
     * @covers ::enrich
     */
    public function testEnrichWithSourceEnricher()
    {
        /** @var DataEnricherInterface|PHPUnit_Framework_MockObject_MockObject $enricher */
        $enricher  = $this->createMock(DataEnricherInterface::class);
        $aggregate = new AggregateEnricher();
        $data      = new ArrayObject();
        $document  = $this->createDocument();
        $source    = $this->createMock(SourceInterface::class);

        $aggregate->addEnricher($enricher);

        $document
            ->expects($this->once())
            ->method('getSource')
            ->willReturn($source);

        $enricher
            ->expects($this->once())
            ->method('enrich')
            ->with(
                $this->isInstanceOf(ArrayAccess::class),
                $this->isInstanceOf(DocumentInterface::class)
            )
            ->willReturnCallback(
                function (ArrayAccess $data, DocumentInterface $document) {
                    $data->offsetSet('source', $document->getSource());
                }
            );

        $aggregate->enrich($data, $document);

        $this->assertTrue($data->offsetExists('source'));
        $this->assertSame($source, $data->offsetGet('source'));
    }
}
