<?php
namespace ZeroConfig\Preacher\Document;

use ZeroConfig\Preacher\Source\SourceIteratorInterface;

class DocumentFeed implements DocumentFeedInterface
{
    /** @var SourceIteratorInterface */
    private $sources;

    /** @var DocumentFactoryInterface */
    private $factory;

    /** @var DocumentHeap|DocumentInterface[] */
    private $documents;

    /**
     * Constructor.
     *
     * @param SourceIteratorInterface $sources
     * @param DocumentFactoryInterface $factory
     */
    public function __construct(
        SourceIteratorInterface $sources,
        DocumentFactoryInterface $factory
    ) {
        $this->sources = $sources;
        $this->factory = $factory;
    }

    /**
     * @return DocumentHeap|DocumentInterface[]
     */
    private function getDocuments(): DocumentHeap
    {
        if ($this->documents === null) {
            $this->documents = new DocumentHeap();

            foreach ($this->sources as $source) {
                $this->documents->insert(
                    $this->factory->createDocument($source)
                );
            }
        }

        return $this->documents;
    }

    /**
     * Move forward to next element.
     *
     * @return void
     */
    public function next()
    {
        $this->getDocuments()->next();
    }

    /**
     * Get the current key.
     *
     * @return int
     */
    public function key(): int
    {
        return $this->getDocuments()->key();
    }

    /**
     * Checks if the current position is valid.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->getDocuments()->valid();
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void
     */
    public function rewind()
    {
        $this->getDocuments()->rewind();
    }

    /**
     * Get the current document.
     *
     * @return DocumentInterface
     */
    public function current(): DocumentInterface
    {
        return $this->getDocuments()->current();
    }
}
