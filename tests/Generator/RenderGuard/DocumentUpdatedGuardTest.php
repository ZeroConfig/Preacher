<?php
namespace ZeroConfig\Preacher\Tests\Generator\RenderGuard;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\DocumentUpdatedGuard;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\RenderGuard\DocumentUpdatedGuard
 */
class DocumentUpdatedGuardTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return DocumentInterface[][]|bool[][]
     */
    public function documentProvider(): array
    {
        return [
            [
                $this->createDocument(
                    new DateTimeImmutable('now'),
                    new DateTimeImmutable('now')
                ),
                false
            ],
            [
                $this->createDocument(
                    new DateTimeImmutable('+12 seconds'),
                    new DateTimeImmutable('now')
                ),
                false
            ],
            [
                $this->createDocument(
                    new DateTimeImmutable('now'),
                    new DateTimeImmutable('+2 seconds')
                ),
                true
            ]
        ];
    }

    /**
     * @param DateTimeInterface $dateGenerated
     * @param DateTimeInterface $dateSourceUpdated
     *
     * @return DocumentInterface
     */
    private function createDocument(
        DateTimeInterface $dateGenerated,
        DateTimeInterface $dateSourceUpdated
    ): DocumentInterface {
        /** @var DocumentInterface|PHPUnit_Framework_MockObject_MockObject $document */
        $document = $this->createMock(DocumentInterface::class);

        $document
            ->expects($this->atLeastOnce())
            ->method('getDateGenerated')
            ->willReturn($dateGenerated);

        $document
            ->expects($this->atLeastOnce())
            ->method('getDateSourceUpdated')
            ->willReturn($dateSourceUpdated);

        return $document;
    }

    /**
     * @dataProvider documentProvider
     *
     * @param DocumentInterface $document
     * @param bool              $expected
     *
     * @return void
     * @covers ::isRenderRequired
     */
    public function testIsRenderRequired(
        DocumentInterface $document,
        bool $expected
    ) {
        $guard = new DocumentUpdatedGuard();

        $this->assertTrue($expected === $guard->isRenderRequired($document));
    }
}
