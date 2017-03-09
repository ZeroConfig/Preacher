<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Document\DocumentInterface;

class DocumentUpdatedGuard implements RenderGuardInterface
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
        return $document->getDateSourceUpdated() > $document->getDateGenerated();
    }
}
