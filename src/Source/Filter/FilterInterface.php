<?php
namespace ZeroConfig\Preacher\Source\Filter;

use SplFileInfo;

interface FilterInterface
{
    /**
     * Check whether the given file is allowed according to the current filter.
     *
     * @param SplFileInfo $file
     *
     * @return bool
     */
    public function isFileAllowed(SplFileInfo $file): bool;
}
