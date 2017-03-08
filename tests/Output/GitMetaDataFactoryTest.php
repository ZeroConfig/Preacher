<?php
namespace ZeroConfig\Preacher\Tests\Output;

use Coyl\Git\ConsoleException;
use Coyl\Git\GitRepo;
use org\bovigo\vfs\vfsStream;
use ZeroConfig\Preacher\Output\GitMetaDataFactory;
use ZeroConfig\Preacher\Output\MetaDataInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Output\GitMetaDataFactory
 */
class GitMetaDataFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return GitMetaDataFactory
     * @covers ::__construct
     */
    public function testConstructor(): GitMetaDataFactory
    {
        /** @noinspection PhpParamsInspection */
        return new GitMetaDataFactory(
            $this->createMock(GitRepo::class)
        );
    }

    /**
     * @return MetaDataInterface
     * @covers ::createMetaData
     */
    public function testCreateMetaData(): MetaDataInterface
    {
        $repository = $this->createMock(GitRepo::class);

        /** @noinspection PhpParamsInspection */
        $factory = new GitMetaDataFactory($repository);

        $root = vfsStream::setup(
            sha1(__FILE__),
            0644,
            []
        );

        $file = $root->url() . '/foo';

        $repository
            ->expects($this->at(0))
            ->method('add')
            ->with($file);

        $repository
            ->expects($this->at(1))
            ->method('commit')
            ->with($this->isType('string'));

        $repository
            ->expects($this->at(2))
            ->method('log')
            ->with(
                $this->matchesRegularExpression(
                    sprintf(
                        '/%s$/',
                        preg_quote($file, '/')
                    )
                )
            )
            ->willReturn('2017-02-02 13:37:42');

        return $factory->createMetaData($file);
    }

    /**
     * @return MetaDataInterface
     * @covers ::createMetaData
     */
    public function testCreateMetaDataForUnregisteredFile(): MetaDataInterface
    {
        $repository = $this->createMock(GitRepo::class);

        /** @noinspection PhpParamsInspection */
        $factory = new GitMetaDataFactory($repository);

        $root = vfsStream::setup(
            sha1(__FILE__),
            0644,
            []
        );

        $file = $root->url() . '/foo';

        $repository
            ->expects($this->at(0))
            ->method('add')
            ->with($file)
            ->willThrowException(new ConsoleException('Foo'));

        $repository
            ->expects($this->at(1))
            ->method('log')
            ->with(
                $this->matchesRegularExpression(
                    sprintf(
                        '/%s$/',
                        preg_quote($file, '/')
                    )
                )
            )
            ->willReturn('2017-02-02 13:37:42');

        return $factory->createMetaData($file);
    }
}
