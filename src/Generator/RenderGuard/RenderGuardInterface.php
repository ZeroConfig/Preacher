<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Generator\Context\ContextInterface;

interface RenderGuardInterface
{
    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param ContextInterface $context
     *
     * @return bool
     */
    public function isRenderRequired(ContextInterface $context): bool;
}
