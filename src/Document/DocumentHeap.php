<?php
namespace ZeroConfig\Preacher\Document;

use InvalidArgumentException;
use SplHeap;

class DocumentHeap extends SplHeap
{
    /**
     * Compare the given documents by date published.
     *
     * @param DocumentInterface $documentA
     * @param DocumentInterface $documentB
     *
     * @return int
     *
     * @throws InvalidArgumentException When either document does not implement
     *   the DocumentInterface.
     */
    protected function compare($documentA, $documentB): int
    {
        if (!$documentA instanceof DocumentInterface
            || !$documentB instanceof DocumentInterface
        ) {
            throw new InvalidArgumentException(
                'Documents must implement: ' . DocumentInterface::class
            );
        }

        $dateA = $documentA->getDatePublished();
        $dateB = $documentB->getDatePublished();

        return $dateA->getTimestamp() - $dateB->getTimestamp();
    }
}
