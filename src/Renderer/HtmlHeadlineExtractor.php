<?php
namespace ZeroConfig\Preacher\Renderer;

class HtmlHeadlineExtractor implements HeadlineExtractorInterface
{
    /**
     * Extract the headline from the given content.
     *
     * @param string $content
     *
     * @return string
     */
    public function extractHeadline(string $content): string
    {
        $headline = '';

        if (preg_match('/<h1>(.+?)<\/h1>/', $content, $matches)) {
            $headline = next($matches);
        }

        return $headline;
    }
}
