<?php
namespace ZeroConfig\Preacher\Generator\RenderGuard;

use ZeroConfig\Preacher\Generator\Context\ContextInterface;

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
     * @param \ZeroConfig\Preacher\Generator\Context\ContextInterface $context
     *
     * @return bool
     */
    public function isRenderRequired(ContextInterface $context): bool
    {
        return array_reduce(
            $this->guards,
            function (
                bool $memo,
                RenderGuardInterface $guard
            ) use ($context) : bool {
                return $memo ?: $guard->isRenderRequired($context);
            },
            false
        );
    }
}
