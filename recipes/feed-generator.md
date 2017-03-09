# Generating document feeds

When a website or blog becomes more popular, the need for something like an Atom
feed or RSS feed becomes more apparent. Content syndication will help a site grow
and create a more stable readership, as you provide readers with a means to keep
themselves updated when a new article arrives.

![Installing](https://imgs.xkcd.com/comics/installing.png)

> But still, my scheme for creating and saving user config files and data locally to preserve them across reinstalls might be useful for--wait, that's cookies.

# Adding a feed generator

One has to implement the `FeedGeneratorInterface`.

```php
<?php
use ZeroConfig\Preacher\Feed\FeedGeneratorInterface;
use ZeroConfig\Preacher\Document\DocumentFeedInterface;

class AtomFeedGenerator implements FeedGeneratorInterface
{
    /** @var AtomFeedWriterInterface */
    private $writer;
    
    /**
     * Constructor.
     * 
     * @param AtomFeedWriterInterface $writer
     */
    public function __construct(AtomFeedWriterInterface $writer)
    {
        $this->writer = $writer;
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
        $atomFeed = new MyAtomFeed();
        
        foreach ($documents as $document) {
            $atomFeed->addDocument($document);
        }
        
        $this->writer->writeFeed($atomFeed);
    }
}
```

Note that the documents received by the generator are sorted by publication date,
in descending order. So the newest publication comes in first, etc.

When a custom sorting order is required, use
[`iterator_to_array`](https://secure.php.net/manual/en/function.iterator-to-array.php)
to transform the document feed in an array and sort that to the requirements of
the feed generator.

Now the generator must be added to the feed generator aggregate:

```yaml
services:
    
  my_bundle.preacher.feed_generator.atom:
    class: AtomFeedGenerator
    arguments:
      - '@my_bundle.preacher.feed_writer'
    tags:
      - { name: 'preacher.feed_generator' }
```

Note the tag `preacher.feed_generator`, which makes it so the feed generator is
picked up by Preacher as a feed generator.

To put this all in a reusable extension, read
[Creating a Preacher plugin](custom-plugins.html).
