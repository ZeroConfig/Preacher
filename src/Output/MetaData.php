<?php
namespace ZeroConfig\Preacher\Output;

use DateTimeInterface;

class MetaData implements MetaDataInterface
{
    /** @var DateTimeInterface */
    private $datePublished;

    /** @var DateTimeInterface */
    private $dateGenerated;

    /**
     * Constructor.
     *
     * @param DateTimeInterface $datePublished
     * @param DateTimeInterface $dateGenerated
     */
    public function __construct(
        DateTimeInterface $datePublished,
        DateTimeInterface $dateGenerated
    ) {
        $this->datePublished = $datePublished;
        $this->dateGenerated = $dateGenerated;
    }

    /**
     * Get the date at which the output file has been first created.
     *
     * @return DateTimeInterface
     */
    public function getDatePublished(): DateTimeInterface
    {
        return $this->datePublished;
    }

    /**
     * Get the date at which the output is being / has been generated in the
     * current generation run.
     *
     * @return DateTimeInterface
     */
    public function getDateGenerated(): DateTimeInterface
    {
        return $this->dateGenerated;
    }
}
