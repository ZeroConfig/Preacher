<?php
namespace ZeroConfig\Preacher\Tests\Template;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use ZeroConfig\Preacher\Template\TemplateLocator;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Template\TemplateLocator
 */
class TemplateLocatorTest extends \PHPUnit_Framework_TestCase
{
    use CreateOutputTrait;

    /** @var vfsStreamDirectory */
    private $root;

    /**
     * Set up the virtual file system.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->root = vfsStream::setup(
            sha1(__FILE__),
            0644,
            [
                'default.html.twig' => '{{ content }}',
                'foo.html' => '',
                'foo.html.twig' => 'FooBarBaz'
            ]
        );
    }

    /**
     * @return void
     * @covers ::__construct
     *
     * @expectedException \ZeroConfig\Preacher\Template\MissingTemplateException
     */
    public function testConstructorWithMissingDefault()
    {
        new TemplateLocator('non-existent.html.twig');
    }

    /**
     * @return TemplateLocator
     * @covers ::__construct
     */
    public function testConstructor(): TemplateLocator
    {
        return new TemplateLocator(
            $this->root->getChild('default.html.twig')->url()
        );
    }

    /**
     * @depends testConstructor
     *
     * @param TemplateLocator $locator
     *
     * @return void
     * @covers ::locateTemplate
     */
    public function testLocateTemplate(TemplateLocator $locator)
    {
        $this->assertEquals(
            $this->root->getChild('foo.html.twig')->url(),
            $locator->locateTemplate(
                $this->createOutput('foo.html', $this->root)
            )
        );

        $this->assertEquals(
            $this->root->getChild('default.html.twig')->url(),
            $locator->locateTemplate(
                $this->createOutput('bar.html', $this->root)
            )
        );
    }
}
