<?php
namespace ZeroConfig\Preacher\Tests\Source\Filter;

use Coyl\Git\GitRepo;
use PHPUnit_Framework_TestCase;
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\GitFilter;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\Filter\GitFilter
 */
class GitFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return GitFilter
     *
     * @covers ::__construct
     */
    public function testConstructor(): GitFilter
    {
        /** @noinspection PhpParamsInspection */
        return new GitFilter(
            $this->createMock(GitRepo::class)
        );
    }

    /**
     * @return bool
     * @covers ::isFileAllowed
     */
    public function testIsFileAllowed(): bool
    {
        $repository = $this->createMock(GitRepo::class);

        /** @noinspection PhpParamsInspection */
        $filter = new GitFilter($repository);

        $file = $this->createMock(SplFileInfo::class);

        $file
            ->expects($this->once())
            ->method('getRealPath')
            ->willReturn('/foo/bar/baz');

        $repository
            ->expects($this->once())
            ->method('getRepoPath')
            ->willReturn('/foo/bar');

        $repository
            ->expects($this->once())
            ->method('logFormatted')
            ->with('1', 'baz', 1)
            ->willReturn('1');

        /** @noinspection PhpParamsInspection */
        return $filter->isFileAllowed($file);
    }
}
