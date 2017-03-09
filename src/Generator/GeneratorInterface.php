<?php
namespace ZeroConfig\Preacher\Generator;

use ZeroConfig\Preacher\Document\DocumentInterface;

interface GeneratorInterface
{
    /**
     * Generate the file for the given document.
     *
     * @param DocumentInterface $document
     *
     * @return void
     */
    public function generate(DocumentInterface $document);
}
