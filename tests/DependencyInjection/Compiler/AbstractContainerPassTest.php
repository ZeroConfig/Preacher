<?php
namespace ZeroConfig\Preacher\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use ZeroConfig\Preacher\DependencyInjection\Compiler\AbstractContainerPass;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\DependencyInjection\Compiler\AbstractContainerPass
 */
class AbstractContainerPassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return AbstractContainerPass
     *
     * @covers ::process
     */
    public function testProcess(): AbstractContainerPass
    {
        /** @var AbstractContainerPass|PHPUnit_Framework_MockObject_MockObject $pass */
        $pass = $this->getMockForAbstractClass(AbstractContainerPass::class);

        $pass
            ->expects($this->once())
            ->method('getContainerIdentifier')
            ->willReturn('container');

        $pass
            ->expects($this->once())
            ->method('getMethodName')
            ->willReturn('addChild');

        $pass
            ->expects($this->once())
            ->method('getTagName')
            ->willReturn('tag');

        /** @var ContainerBuilder|PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        /** @var Definition|PHPUnit_Framework_MockObject_MockObject $definition */
        $definition = $this->createMock(Definition::class);

        $container
            ->expects($this->once())
            ->method('getDefinition')
            ->with('container')
            ->willReturn($definition);

        $container
            ->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with('tag')
            ->willReturn(['foo' => true, 'bar' => true, 'baz' => true]);

        $definition
            ->expects($this->exactly(3))
            ->method('addMethodCall')
            ->with(
                'addChild',
                $this->isType('array')
            );

        $pass->process($container);

        return $pass;
    }

    /**
     * @return void
     * @covers ::process
     */
    public function testMissingDefinition()
    {
        /** @var AbstractContainerPass|PHPUnit_Framework_MockObject_MockObject $pass */
        $pass = $this->getMockForAbstractClass(AbstractContainerPass::class);

        $pass
            ->expects($this->once())
            ->method('getContainerIdentifier')
            ->willReturn('container');

        $pass
            ->expects($this->never())
            ->method('getMethodName');

        $pass
            ->expects($this->never())
            ->method('getTagName');

        /** @var ContainerBuilder|PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        $container
            ->expects($this->once())
            ->method('getDefinition')
            ->with('container')
            ->willThrowException(
                new ServiceNotFoundException('Missing service')
            );

        $container
            ->expects($this->never())
            ->method('findTaggedServiceIds');

        $pass->process($container);
    }
}
