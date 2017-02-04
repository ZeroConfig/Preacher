<?php
namespace ZeroConfig\Preacher\Output;

use ZeroConfig\Preacher\Source\SourceInterface;

class OutputFactory implements OutputFactoryInterface
{
    /** @var SourceTranslatorInterface */
    private $pathTranslator;

    /** @var MetaDataFactoryInterface */
    private $metaDataFactory;

    /**
     * Constructor.
     *
     * @param SourceTranslatorInterface $pathTranslator
     * @param MetaDataFactoryInterface  $metaDataFactory
     */
    public function __construct(
        SourceTranslatorInterface $pathTranslator,
        MetaDataFactoryInterface $metaDataFactory
    ) {
        $this->pathTranslator = $pathTranslator;
        $this->metaDataFactory = $metaDataFactory;
    }

    /**
     * Create an output entity for the given source.
     *
     * @param SourceInterface $source
     *
     * @return OutputInterface
     */
    public function createOutput(SourceInterface $source): OutputInterface
    {
        $file = $this->pathTranslator->getOutputPath($source);

        return new Output(
            $file,
            $this->metaDataFactory->createMetaData($file)
        );
    }
}
