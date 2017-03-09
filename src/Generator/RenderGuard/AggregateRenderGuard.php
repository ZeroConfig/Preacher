<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Document\DocumentInterface;

class AggregateRenderGuard implements RenderGuardInterface
{
    /** @var RenderGuardInterface[] */
    private $guards = [];

    /**
     * Add a render guard to the aggregate.
     *
     * @param RenderGuardInterface $guard
     *
     * @return void
     */
    public function addGuard(RenderGuardInterface $guard)
    {
        $this->guards[spl_object_hash($guard)] = $guard;
    }

    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param DocumentInterface $document
     *
     * @return bool
     */
    public function isRenderRequired(DocumentInterface $document): bool
    {
        return array_reduce(
            $this->guards,
            function (
                bool $memo,
                RenderGuardInterface $guard
            ) use ($document) : bool {
                return $memo ?: $guard->isRenderRequired($document);
            },
            false
        );
    }
}
