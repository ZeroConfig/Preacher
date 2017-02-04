<?php
namespace ZeroConfig\Preacher\Output;

use DateTimeImmutable;

class UpdatedOutput implements OutputInterface
{
    /** @var OutputInterface */
    private $output;

    /** @var MetaDataInterface */
    private $metaData;

    /**
     * Constructor.
     *
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output   = $output;
        $this->metaData = new MetaData(
            $output->getMetaData()->getDatePublished(),
            new DateTimeImmutable()
        );
    }

    /**
     * Get the path to the output file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->output->getPath();
    }

    /**
     * Get the meta data for the output file.
     *
     * @return MetaDataInterface
     */
    public function getMetaData(): MetaDataInterface
    {
        return $this->metaData;
    }
}
