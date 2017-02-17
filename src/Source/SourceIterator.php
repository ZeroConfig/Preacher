<?php
namespace ZeroConfig\Preacher\Source;

use ArrayIterator;
use CallbackFilterIterator;
use Iterator;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\FilterInterface;

class SourceIterator implements SourceIteratorInterface
{
    /** @var Iterator */
    private $files;

    /** @var SourceInterface[]|Iterator */
    private $sources;

    /** @var SourceFactoryInterface */
    private $factory;

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * Constructor.
     *
     * @param Iterator               $files
     * @param SourceFactoryInterface $factory
     */
    public function __construct(Iterator $files, SourceFactoryInterface $factory)
    {
        $this->files   = new CallbackFilterIterator($files, $this);
        $this->factory = $factory;
    }

    /**
     * Add the given filter to the iterator.
     *
     * @param FilterInterface $filter
     *
     * @return void
     */
    public function addFilter(FilterInterface $filter)
    {
        array_push($this->filters, $filter);
    }

    /**
     * Filter the given file.
     *
     * @param SplFileInfo $file
     * @param string      $relativePath
     *
     * @return bool
     */
    public function __invoke(SplFileInfo $file, string $relativePath): bool
    {
        return array_reduce(
            $this->filters,
            function (
                bool $memo,
                FilterInterface $filter
            ) use (
                $file,
                $relativePath
            ) : bool {
                return $memo && $filter->isFileAllowed($file, $relativePath);
            },
            true
        );
    }

    /**
     * Get the sources.
     *
     * @return Iterator|SourceInterface[]
     */
    private function getSources(): Iterator
    {
        if ($this->sources === null) {
            $this->sources = new ArrayIterator(
                array_map(
                    function (string $path): SourceInterface {
                        return $this->factory->createSource($path);
                    },
                    array_keys(
                        iterator_to_array($this->files)
                    )
                )
            );
        }

        return $this->sources;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->getSources()->next();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->getSources()->key();
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->getSources()->valid();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->getSources()->rewind();
    }

    /**
     * Get the current source.
     *
     * @return SourceInterface
     */
    public function current(): SourceInterface
    {
        return $this->getSources()->current();
    }
}
