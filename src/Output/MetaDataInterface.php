<?php
namespace ZeroConfig\Preacher\Output;

use DateTimeInterface;

interface MetaDataInterface
{
    /**
     * Get the date at which the output file has been first created.
     *
     * @return DateTimeInterface
     */
    public function getDatePublished(): DateTimeInterface;

    /**
     * Get the date at which the output is being / has been generated in the
     * current generation run.
     *
     * @return DateTimeInterface
     */
    public function getDateGenerated(): DateTimeInterface;
}
