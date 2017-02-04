<?php
namespace ZeroConfig\Preacher\Output;

use ZeroConfig\Preacher\Source\SourceInterface;

class MarkdownSourceTranslator implements SourceTranslatorInterface
{
    /** @var string */
    private $extension;

    /**
     * Constructor.
     *
     * @param string $extension
     */
    public function __construct(string $extension = 'html')
    {
        $this->extension = '.' . ltrim($extension, '.');
    }

    /**
     * Get the path to the output file name for the given source.
     *
     * @param SourceInterface $source
     *
     * @return string
     */
    public function getOutputPath(SourceInterface $source): string
    {
        return preg_replace(
            '/\.md$/',
            $this->extension,
            $source->getPath()
        );
    }
}
