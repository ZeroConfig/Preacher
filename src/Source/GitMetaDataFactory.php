<?php
namespace ZeroConfig\Preacher\Source;

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
     * Create a meta data instance for the given relative file name.
     *
     * @param string $file
     *
     * @return MetaDataInterface
     */
    public function createMetaData(string $file): MetaDataInterface
    {
        $repository = $this->repository;

        list(
            $longRef,
            $shortRef,
            $authorName,
            $authorEmail
        ) = explode(
            PHP_EOL,
            $repository->logFormatted(
                implode(
                    '%n',
                    ['%H', '%h', '%aN', '%aE']
                ),
                $file,
                1
            )
        );

        // Date added.
        $dateCreated = $repository->log(
            '-1 --pretty=format:%aD --diff-filter=A ' . $file
        );

        $numRevisions = array_reduce(
            explode(
                PHP_EOL,
                $repository->log('--pretty=format:1 --no-merges ' . $file)
            ),
            function (int $carry, string $entry): int {
                return $carry + intval($entry);
            },
            0
        );

        return new MetaData(
            new CommitReference($longRef, $shortRef),
            new Author($authorName, $authorEmail),
            new DateTimeImmutable($dateCreated),
            new DateTimeImmutable(
                sprintf('@%d', filemtime($file))
            ),
            $numRevisions
        );
    }
}
