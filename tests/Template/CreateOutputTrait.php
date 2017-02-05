<?php
namespace ZeroConfig\Preacher\Tests\Template;

use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit_Framework_MockObject_MockObject;
use ZeroConfig\Preacher\Output\OutputInterface;

trait CreateOutputTrait
{
    /**
     * @param string             $path
     * @param vfsStreamDirectory $root
     *
     * @return PHPUnit_Framework_MockObject_MockObject|OutputInterface
     */
    protected function createOutput(string $path, vfsStreamDirectory $root)
    {
        $output = $this->createMock(OutputInterface::class);
        $url    = $path;

        if ($root->hasChild($path)) {
            $url = $root->getChild($path)->url();
        }

        $output
            ->expects($this->once())
            ->method('getPath')
            ->willReturn($url);

        return $output;
    }
}
