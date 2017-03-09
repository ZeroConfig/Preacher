<?php
namespace ZeroConfig\Preacher\Document;

use Iterator;

interface DocumentFeedInterface extends Iterator
{
    /**
     * Get the current document.
     *
     * @return DocumentInterface
     */
    public function current(): DocumentInterface;
}
