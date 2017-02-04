<?php
namespace ZeroConfig\Preacher\Generator;

use Parsedown;
use SplFileObject;
use ZeroConfig\Preacher\Source\SourceInterface;

class MarkdownSourceReader implements SourceReaderInterface
{
    /** @var Parsedown */
    private $parser;

    /**
     * Constructor.
     *
     * @param Parsedown $parser
     */
    public function __construct(Parsedown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Get the contents of the given source.
     *
     * @param SourceInterface $source
     *
     * @return string
     */
    public function getContents(SourceInterface $source): string
    {
        $file     = new SplFileObject($source->getPath(), 'w');
        $markdown = implode('', iterator_to_array($file));

        return $this->parser->text($markdown);
    }
}
