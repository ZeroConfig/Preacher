<?php
namespace ZeroConfig\Preacher\Feed;

use ZeroConfig\Preacher\Document\DocumentFeedInterface;

interface FeedGeneratorInterface
{
    /**
     * Generate a feed for the given documents.
     *
     * @param DocumentFeedInterface $documents
     *
     * @return void
     */
    public function generateFeed(DocumentFeedInterface $documents);
}
