<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Generator\Context\ContextInterface;

class DocumentPublishedGuard implements RenderGuardInterface
{
    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param ContextInterface $context
     *
     * @return bool
     */
    public function isRenderRequired(ContextInterface $context): bool
    {
        $generated = $context->getOutput()->getMetaData()->getDateGenerated();
        $published = $context->getOutput()->getMetaData()->getDatePublished();

        // This ensures that within the first 10 seconds of committing the
        // document to version control for the first time, it will always
        // generate output.
        return $generated->getTimestamp() - 10 < $published->getTimestamp();
    }
}
