<?php
namespace ZeroConfig\Preacher\Source;

class MarkdownSource extends AbstractSource
{
    /**
     * Extract the basename from the given path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function extractBaseName(string $path): string
    {
        return basename($path, '.md');
    }
}
