<?php
namespace ZeroConfig\Preacher\Tests\Source\Filter;

use PHPUnit_Framework_TestCase;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\FileFilter;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Filter\FileFilter
 */
class FileFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return bool
     *
     * @covers ::isFileAllowed
     */
    public function testIsFileAllowed(): bool
    {
        $filter = new FileFilter();

        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('isFile')
            ->willReturn(true);

        /** @noinspection PhpParamsInspection */
        return $filter->isFileAllowed($file);
    }
}
