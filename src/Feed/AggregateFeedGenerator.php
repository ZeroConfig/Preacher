<?php
namespace ZeroConfig\Preacher\Feed;

use ZeroConfig\Preacher\Document\DocumentFeedInterface;

class AggregateFeedGenerator implements FeedGeneratorInterface
{
    /** @var FeedGeneratorInterface[] */
    private $generators = [];

    /**
     * Add a generator to the list of generators.
     *
     * @param FeedGeneratorInterface $generator
     *
     * @return void
     */
    public function addGenerator(FeedGeneratorInterface $generator)
    {
        $this->generators[spl_object_hash($generator)] = $generator;
    }

    /**
     * Generate a feed for the given documents.
     *
     * @param DocumentFeedInterface $documents
     *
     * @return void
     */
    public function generateFeed(DocumentFeedInterface $documents)
    {
        foreach ($this->generators as $generator) {
            $generator->generateFeed($documents);
        }
    }
}
