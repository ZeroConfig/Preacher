<?php
namespace ZeroConfig\Preacher\Tests\Generator;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Generator\HtmlHeadlineExtractor;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\HtmlHeadlineExtractor
 */
class HtmlHeadlineExtractorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     * @covers ::extractHeadline
     */
    public function testConstructor()
    {
        $extractor = new HtmlHeadlineExtractor();

        $this->assertEquals(
            'My awesome adventure > Part 2',
            $extractor->extractHeadline(
                '<p><h1>My awesome adventure > Part 2</h1></p><p>Foo bar</p><h1>Baz</h1>'
            )
        );
    }
}
