<?php
namespace ZeroConfig\Preacher\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use ZeroConfig\Preacher\DependencyInjection\Compiler\SourceFilterPass;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\DependencyInjection\Compiler\SourceFilterPass
 */
class SourceFilterPassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider containerProvider
     *
     * @param ContainerBuilder $builder
     *
     * @return void
     * @covers ::process
     */
    public function testProcess(ContainerBuilder $builder)
    {
        $pass = new SourceFilterPass();
        $pass->process($builder);
    }

    /**
     * @return ContainerBuilder[][]
     */
    public function containerProvider(): array
    {
        return [
            [$this->createContainerBuilder(false)],
            [$this->createContainerBuilder(true)],
            [$this->createContainerBuilder(false, 'foo', 'bar')],
            [$this->createContainerBuilder(true, 'foo', 'bar')]
        ];
    }

    /**
     * Create a container builder according to the given configuration.
     *
     * @param bool     $hasIterator
     * @param string[] ...$serviceIds
     *
     * @return PHPUnit_Framework_MockObject_MockObject|ContainerBuilder
     */
    // @codingStandardsIgnoreLine
    private function createContainerBuilder(
        bool $hasIterator,
        string ...$serviceIds
    ) {
        $container  = $this->createMock(ContainerBuilder::class);
        $definition = $this->createMock(Definition::class);

        $container
            ->expects($this->once())
            ->method('hasDefinition')
            ->with('preacher.source_iterator')
            ->willReturn($hasIterator);

        $container
            ->expects($hasIterator ? $this->once() : $this->never())
            ->method('findTaggedServiceIds')
            ->with('preacher.source_filter')
            ->willReturn(
                array_fill_keys($serviceIds, [])
            );

        $container
            ->expects($hasIterator ? $this->once() : $this->never())
            ->method('getDefinition')
            ->with('preacher.source_iterator')
            ->willReturn($definition);

        $definition
            ->expects(
                $hasIterator
                    ? $this->exactly(count($serviceIds))
                    : $this->never()
            )
            ->method('addMethodCall')
            ->with(
                $this->isType('string'),
                $this->isType('array')
            );

        return $container;
    }
}
