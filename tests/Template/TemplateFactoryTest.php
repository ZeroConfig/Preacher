<?php
namespace ZeroConfig\Preacher\Tests\Template;

use org\bovigo\vfs\vfsStream;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Template\TemplateFactory;
use ZeroConfig\Preacher\Template\TemplateInterface;
use ZeroConfig\Preacher\Template\TemplateLocatorInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Template\TemplateFactory
 */
class TemplateFactoryTest extends \PHPUnit_Framework_TestCase
{
    use CreateOutputTrait;

    /**
     * @param string $extension
     *
     * @return PHPUnit_Framework_MockObject_MockObject|TemplateLocatorInterface
     */
    private function createLocatorPassThrough(string $extension = 'twig')
    {
        $extension = '.' . ltrim($extension, '.');
        $locator = $this->createMock(TemplateLocatorInterface::class);

        $locator
            ->expects($this->any())
            ->method('locateTemplate')
            ->with($this->isInstanceOf(OutputInterface::class))
            ->willReturnCallback(
                function (OutputInterface $output) use ($extension) : string {
                    return $output->getPath() . $extension;
                }
            );

        return $locator;
    }

    /**
     * @return TemplateFactory
     * @covers ::__construct
     */
    public function testConstructor(): TemplateFactory
    {
        return new TemplateFactory($this->createLocatorPassThrough());
    }

    /**
     * @depends testConstructor
     *
     * @param TemplateFactory $factory
     *
     * @return TemplateInterface
     * @covers ::createTemplate
     */
    public function testCreateTemplate(
        TemplateFactory $factory
    ): TemplateInterface {
        $output = $this->createOutput(
            'foo.html',
            vfsStream::setup(
                sha1(__FILE__),
                0644,
                [
                    'foo.html' => '',
                    'foo.html.twig' => 'FooBarBaz'
                ]
            )
        );

        return $factory->createTemplate($output);
    }
}
