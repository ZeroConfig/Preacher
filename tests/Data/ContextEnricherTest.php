<?php
namespace ZeroConfig\Preacher\Tests\Data;

use ArrayObject;
use ZeroConfig\Preacher\Data\ContextEnricher;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Data\ContextEnricher
 */
class ContextEnricherTest extends AbstractDataEnricherTestCase
{
    /**
     * @return void
     * @covers ::enrich
     */
    public function testEnrich()
    {
        $enricher = new ContextEnricher();
        $data     = new ArrayObject();

        $enricher->enrich($data, $this->createDocument());

        $this->assertTrue($data->offsetExists('template'));
        $this->assertTrue($data->offsetExists('source'));
        $this->assertTrue($data->offsetExists('output'));
    }
}
