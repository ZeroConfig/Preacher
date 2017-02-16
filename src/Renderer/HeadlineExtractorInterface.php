<?php
namespace ZeroConfig\Preacher\Renderer;

interface HeadlineExtractorInterface
{
    /**
     * Extract the headline from the given content.
     *
     * @param string $content
     *
     * @return string
     */
    public function extractHeadline(string $content): string;
}
