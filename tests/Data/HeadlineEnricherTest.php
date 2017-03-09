<?php
namespace ZeroConfig\Preacher\Tests\Data;

use ArrayObject;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Preacher\Data\HeadlineEnricher;
use ZeroConfig\Preacher\Renderer\HeadlineExtractorInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Data\HeadlineEnricher
 */
class HeadlineEnricherTest extends AbstractDataEnricherTestCase
{
    /**
     * @return HeadlineEnricher
     *
     * @covers ::__construct
     */
    public function testConstructor(): HeadlineEnricher
    {
        return new HeadlineEnricher($this->createExtractor());
    }

    /**
     * @return HeadlineExtractorInterface
     */
    private function createExtractor(): HeadlineExtractorInterface
    {
        /** @var HeadlineExtractorInterface|PHPUnit_Framework_MockObject_MockObject $extractor */
        $extractor = $this->createMock(HeadlineExtractorInterface::class);

        $extractor
            ->expects($this->any())
            ->method('extractHeadline')
            ->with($this->isType('string'))
            ->willReturnArgument(0);

        return $extractor;
    }

    /**
     * @depends testConstructor
     *
     * @param HeadlineEnricher $enricher
     *
     * @return void
     * @covers ::enrich
     */
    public function testEnrichWithoutContent(HeadlineEnricher $enricher)
    {
        $templateData = new ArrayObject();

        $enricher->enrich($templateData, $this->createDocument());

        $this->assertTrue($templateData->offsetExists('headline'));
        $this->assertEmpty($templateData->offsetGet('headline'));
    }

    /**
     * @depends testConstructor
     *
     * @param HeadlineEnricher $enricher
     *
     * @return void
     * @covers ::enrich
     */
    public function testEnrichWithEmptyContent(HeadlineEnricher $enricher)
    {
        $templateData = new ArrayObject(['content' => '']);

        $enricher->enrich($templateData, $this->createDocument());

        $this->assertTrue($templateData->offsetExists('headline'));
        $this->assertEmpty($templateData->offsetGet('headline'));
    }

    /**
     * @depends testConstructor
     *
     * @param HeadlineEnricher $enricher
     *
     * @return void
     * @covers ::enrich
     */
    public function testEnrichWithFilledContent(HeadlineEnricher $enricher)
    {
        $templateData = new ArrayObject(['content' => 'Foo']);

        $enricher->enrich($templateData, $this->createDocument());

        $this->assertTrue($templateData->offsetExists('headline'));
        $this->assertNotEmpty($templateData->offsetGet('headline'));
    }
}
