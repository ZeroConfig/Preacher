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
        $generated = $document->getDateGenerated();
        $published = $document->getDatePublished();

        // This ensures that within the first 10 seconds of committing the
        // document to version control for the first time, it will always
        // generate output.
        $gracePeriod = 10;

        // Use a more accurate grace period, to prevent duplicate renders.
        if (array_key_exists('REQUEST_TIME', $_SERVER)) {
            // Requires at least 2 seconds to compensate for runtime.
            $gracePeriod = 2 + time() - $_SERVER['REQUEST_TIME'];
        }

        return $generated->getTimestamp() - $gracePeriod < $published->getTimestamp();
    }
}
