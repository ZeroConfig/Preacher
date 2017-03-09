<?php
namespace ZeroConfig\Preacher\Document;

use ZeroConfig\Preacher\Source\SourceInterface;

interface DocumentFactoryInterface
{
    /**
     * Create a context for the given source.
     *
     * @param SourceInterface $source
     *
     * @return DocumentInterface
     */
    public function createDocument(SourceInterface $source): DocumentInterface;
}
