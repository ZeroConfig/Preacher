<?php
namespace ZeroConfig\Preacher\Tests\Data;

use ArrayObject;
use ZeroConfig\Preacher\Data\ContentEnricher;
use ZeroConfig\Preacher\Renderer\SourceReaderInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Data\ContentEnricher
 */
class ContentEnricherTest extends AbstractDataEnricherTestCase
{
    /**
     * @return ContentEnricher
     *
     * @covers ::__construct
     */
    public function testConstructor(): ContentEnricher
    {
        /** @noinspection PhpParamsInspection */
        return new ContentEnricher(
            $this->createMock(SourceReaderInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param ContentEnricher $enricher
     *
     * @return void
     * @covers ::enrich
     */
    public function testEnrich(ContentEnricher $enricher)
    {
        $data = new ArrayObject();
        $enricher->enrich($data, $this->createDocument());
        $this->assertTrue($data->offsetExists('content'));
    }
}
