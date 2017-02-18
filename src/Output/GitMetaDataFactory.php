<?php
namespace ZeroConfig\Preacher\Output;

use Coyl\Git\ConsoleException;
use Coyl\Git\GitRepo;
use DateTimeImmutable;

class GitMetaDataFactory implements MetaDataFactoryInterface
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
     * Create meta data for the given output path.
     *
     * @param string $path
     *
     * @return MetaDataInterface
     */
    public function createMetaData(string $path): MetaDataInterface
    {
        $repository = $this->repository;

        if (!file_exists($path)) {
            touch($path);
            chmod($path, 0644);

            try {
                $repository->add($path);
                $repository->commit('Created file');
            } catch (ConsoleException $e) {
                // This happens when a file could not be added.
                // For instance, when it is disallowed by GIT ignore.
            }
        }

        return new MetaData(
            new DateTimeImmutable(
                $repository->log(
                    '-1 --pretty=format:%aD --diff-filter=A ' . $path
                )
            ),
            new DateTimeImmutable(
                sprintf('@%d', filemtime($path))
            )
        );
    }
}
