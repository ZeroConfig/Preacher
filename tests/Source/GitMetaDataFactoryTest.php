<?php
namespace ZeroConfig\Preacher\Tests\Source;

use Coyl\Git\GitRepo;
use org\bovigo\vfs\vfsStream;
use ZeroConfig\Preacher\Source\GitMetaDataFactory;
use ZeroConfig\Preacher\Source\MetaDataInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Source\GitMetaDataFactory
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
            0333,
            ['foo' => '']
        );

        $file = $root->getChild('foo')->url();

        $repository
            ->expects($this->at(0))
            ->method('logFormatted')
            ->with(
                $this->isType('string'),
                $file,
                1
            )
            ->willReturn(
                implode(
                    PHP_EOL,
                    [
                        'FooBarBaz',
                        'FooBar',
                        'Author Name',
                        'author@domain.com',
                    ]
                )
            );

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
            ->willReturn(
                implode(PHP_EOL, ['1', '1', '1'])
            );

        return $factory->createMetaData($file);
    }
}
