<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Document\DocumentInterface;

class DocumentUpdatedGuard implements RenderGuardInterface
{
    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param \ZeroConfig\Preacher\Document\DocumentInterface $document
     *
     * @return bool
     */
    public function isRenderRequired(DocumentInterface $document): bool
    {
        $generated = $document->getOutput()->getMetaData()->getDateGenerated();
        $updated   = $document->getSource()->getMetaData()->getDateUpdated();

        return $updated > $generated;
    }
}
