<?php
namespace ZeroConfig\Preacher\Tests\Source\Filter;

use Composer\Config;
use PHPUnit_Framework_TestCase;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\ComposerFilter;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Filter\ComposerFilter
 */
class ComposerFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return ComposerFilter
     *
     * @covers ::__construct
     */
    public function testConstructor(): ComposerFilter
    {
        $config = $this->createMock(Config::class);

        $config
            ->expects($this->once())
            ->method('get')
            ->with('vendor-dir')
            ->willReturn('/foo/bar/vendor');

        /** @noinspection PhpParamsInspection */
        return new ComposerFilter($config);
    }

    /**
     * @depends testConstructor
     *
     * @param ComposerFilter $filter
     *
     * @return bool
     * @covers ::isFileAllowed
     */
    public function testIsFileAllowed(ComposerFilter $filter): bool
    {
        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('getRealPath')
            ->willReturn('/foo/bar/baz');

        /** @noinspection PhpParamsInspection */
        return $filter->isFileAllowed($file);
    }
}
