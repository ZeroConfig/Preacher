<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Document\DocumentInterface;

class DocumentPublishedGuard implements RenderGuardInterface
{
    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param DocumentInterface $document
     *
     * @return bool
     */
    public function isRenderRequired(DocumentInterface $document): bool
    {
        $generated = $document->getOutput()->getMetaData()->getDateGenerated();
        $published = $document->getOutput()->getMetaData()->getDatePublished();

        // This ensures that within the first 10 seconds of committing the
        // document to version control for the first time, it will always
        // generate output.
        return $generated->getTimestamp() - 10 < $published->getTimestamp();
    }
}
