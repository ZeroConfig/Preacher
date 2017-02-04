<?php
namespace ZeroConfig\Preacher\Source;

use DateTimeInterface;

class MetaData implements MetaDataInterface
{
    /** @var CommitReferenceInterface */
    private $version;

    /** @var AuthorInterface */
    private $author;

    /** @var DateTimeInterface */
    private $dateCreated;

    /** @var DateTimeInterface */
    private $dateUpdated;

    /** @var int */
    private $numRevisions;

    /**
     * Constructor.
     *
     * @param CommitReferenceInterface $version
     * @param AuthorInterface          $author
     * @param DateTimeInterface        $dateCreated
     * @param DateTimeInterface        $dateUpdated
     * @param int                      $numRevisions
     */
    public function __construct(
        CommitReferenceInterface $version,
        AuthorInterface $author,
        DateTimeInterface $dateCreated,
        DateTimeInterface $dateUpdated,
        $numRevisions
    ) {
        $this->version      = $version;
        $this->author       = $author;
        $this->dateCreated  = $dateCreated;
        $this->dateUpdated  = $dateUpdated;
        $this->numRevisions = $numRevisions;
    }

    /**
     * Get the author of the most recent revision.
     *
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface
    {
        return $this->author;
    }

    /**
     * Get the date at which the source has been created.
     *
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * Get the date of the most recent revision.
     *
     * @return DateTimeInterface
     */
    public function getDateUpdated(): DateTimeInterface
    {
        return $this->dateUpdated;
    }

    /**
     * Get the commit reference for the most recent version.
     *
     * @return CommitReferenceInterface
     */
    public function getVersion(): CommitReferenceInterface
    {
        return $this->version;
    }

    /**
     * Get the total number of revisions.
     *
     * @return int
     */
    public function getNumRevisions(): int
    {
        return $this->numRevisions;
    }
}
