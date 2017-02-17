<?php
namespace ZeroConfig\Preacher\Source;

use Iterator;

interface SourceIteratorInterface extends Iterator
{
    /**
     * Get the current source.
     *
     * @return SourceInterface
     */
    public function current(): SourceInterface;
}
