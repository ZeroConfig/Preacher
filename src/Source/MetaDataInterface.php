<?php
namespace ZeroConfig\Preacher\Source;

use DateTimeInterface;

interface MetaDataInterface
{
    /**
     * Get the author of the most recent revision.
     *
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface;

    /**
     * Get the date at which the source has been created.
     *
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface;

    /**
     * Get the date of the most recent revision.
     *
     * @return DateTimeInterface
     */
    public function getDateUpdated(): DateTimeInterface;

    /**
     * Set the date at which the source was last updated.
     *
     * @param DateTimeInterface $dateUpdated
     *
     * @return void
     */
    public function setDateUpdated(DateTimeInterface $dateUpdated);

    /**
     * Get the commit reference for the most recent version.
     *
     * @return CommitReferenceInterface
     */
    public function getVersion(): CommitReferenceInterface;

    /**
     * Get the total number of revisions.
     *
     * @return int
     */
    public function getNumRevisions(): int;
}
