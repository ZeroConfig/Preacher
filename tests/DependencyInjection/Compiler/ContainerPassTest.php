<?php
namespace ZeroConfig\Preacher\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use ZeroConfig\Preacher\DependencyInjection\Compiler\ContainerPass;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\DependencyInjection\Compiler\ContainerPass
 */
class ContainerPassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return ContainerPass
     *
     * @covers ::process
     * @covers ::__construct
     */
    public function testProcess(): ContainerPass
    {
        $pass = new ContainerPass('container', 'tag', 'addChild');

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
        $pass = new ContainerPass('container', 'tag', 'addChild');

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
