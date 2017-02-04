<?php
namespace ZeroConfig\Preacher\Output;

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

            $repository->add($path);
            $repository->commit('Created file');
        }

        return new MetaData(
            new DateTimeImmutable(
                $repository->logFormatted('%aD', $path, 1)
            ),
            new DateTimeImmutable(
                sprintf('@%d', filemtime($path))
            )
        );
    }
}
