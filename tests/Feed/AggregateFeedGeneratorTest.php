<?php
namespace ZeroConfig\Preacher\Tests\Feed;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentFeedInterface;
use ZeroConfig\Preacher\Feed\AggregateFeedGenerator;
use ZeroConfig\Preacher\Feed\FeedGeneratorInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Feed\AggregateFeedGenerator
 */
class AggregateFeedGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return PHPUnit_Framework_MockObject_MockObject|DocumentFeedInterface
     */
    private function createDocumentFeed()
    {
        return $this->createMock(DocumentFeedInterface::class);
    }

    /**
     * @return void
     * @covers ::generateFeed
     */
    public function testGenerateFeedWithoutGenerators()
    {
        $generator = new AggregateFeedGenerator();
        $generator->generateFeed($this->createDocumentFeed());
    }

    /**
     * @return void
     * @covers ::generateFeed
     * @covers ::addGenerator
     */
    public function testGenerateFeedWithChildGenerator()
    {
        /** @var FeedGeneratorInterface|PHPUnit_Framework_MockObject_MockObject $child */
        $child     = $this->createMock(FeedGeneratorInterface::class);
        $generator = new AggregateFeedGenerator();

        $child
            ->expects($this->once())
            ->method('generateFeed')
            ->with($this->isInstanceOf(DocumentFeedInterface::class));

        $generator->addGenerator($child);
        $generator->generateFeed($this->createDocumentFeed());
    }
}
