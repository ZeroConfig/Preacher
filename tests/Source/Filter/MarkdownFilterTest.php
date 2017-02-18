<?php
namespace ZeroConfig\Preacher\Tests\Source\Filter;

use PHPUnit_Framework_TestCase;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\MarkdownFilter;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Filter\MarkdownFilter
 */
class MarkdownFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return bool
     *
     * @covers ::isFileAllowed
     */
    public function testIsFileAllowed(): bool
    {
        $filter = new MarkdownFilter();

        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('getExtension')
            ->willReturn('md');

        /** @noinspection PhpParamsInspection */
        return $filter->isFileAllowed($file);
    }
}
