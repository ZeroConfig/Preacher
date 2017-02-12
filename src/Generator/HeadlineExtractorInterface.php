<?php
namespace ZeroConfig\Preacher\Generator;

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
