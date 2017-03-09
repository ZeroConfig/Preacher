<?php
namespace ZeroConfig\Preacher\Tests\Generator\RenderGuard;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\AggregateRenderGuard;
use ZeroConfig\Preacher\Generator\RenderGuard\RenderGuardInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\RenderGuard\AggregateRenderGuard
 */
class AggregateRenderGuardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     * @covers ::isRenderRequired
     */
    public function testEmptyAggregate()
    {
        $guard = new AggregateRenderGuard();

        /** @noinspection PhpParamsInspection */
        $this->assertFalse(
            $guard->isRenderRequired(
                $this->createMock(DocumentInterface::class)
            )
        );
    }

    /**
     * @return void
     * @covers ::addGuard
     * @covers ::isRenderRequired
     */
    public function testGreedyGuard()
    {
        $guard = new AggregateRenderGuard();

        /** @var RenderGuardInterface|PHPUnit_Framework_MockObject_MockObject $greedyGuard */
        $greedyGuard = $this->createMock(RenderGuardInterface::class);
        $greedyGuard
            ->expects($this->once())
            ->method('isRenderRequired')
            ->willReturn(true);

        $guard->addGuard($greedyGuard);

        /** @noinspection PhpParamsInspection */
        $this->assertTrue(
            $guard->isRenderRequired(
                $this->createMock(DocumentInterface::class)
            )
        );
    }
}
