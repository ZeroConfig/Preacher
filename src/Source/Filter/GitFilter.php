<?php
namespace ZeroConfig\Preacher\Source\Filter;

use Coyl\Git\GitRepo;
use SplFileInfo;

class GitFilter implements FilterInterface
{
    /** @var GitRepo */
    private $repository;

    /**
     * Constructor.
     *
     * @param GitRepo $repository
     */
    public function __construct(GitRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check whether the given file is allowed according to the current filter.
     *
     * @param SplFileInfo $file
     *
     * @return bool
     */
    public function isFileAllowed(SplFileInfo $file): bool
    {
        $relativePath = ltrim(
            preg_replace(
                sprintf('/^%s/', preg_quote($this->repository->getRepoPath(), '/')),
                '',
                $file->getRealPath()
            ),
            DIRECTORY_SEPARATOR
        );

        return strlen(
            $this->repository->logFormatted('1', $relativePath, 1)
        ) === 1;
    }
}
