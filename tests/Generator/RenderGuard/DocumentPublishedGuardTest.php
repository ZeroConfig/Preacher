<?php
namespace ZeroConfig\Preacher\Tests\Generator\RenderGuard;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\DocumentPublishedGuard;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\RenderGuard\DocumentPublishedGuard
 */
class DocumentPublishedGuardTest extends PHPUnit_Framework_TestCase
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
                true
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
                    new DateTimeImmutable('+1 seconds'),
                    new DateTimeImmutable('now')
                ),
                true
            ],
            [
                $this->createDocument(
                    new DateTimeImmutable('-10 seconds'),
                    new DateTimeImmutable('-10 seconds')
                ),
                true
            ],
            [
                $this->createDocument(
                    new DateTimeImmutable('-10 seconds'),
                    new DateTimeImmutable('-20 seconds')
                ),
                false
            ]
        ];
    }

    /**
     * @param DateTimeInterface $dateGenerated
     * @param DateTimeInterface $datePublished
     *
     * @return DocumentInterface
     */
    private function createDocument(
        DateTimeInterface $dateGenerated,
        DateTimeInterface $datePublished
    ): DocumentInterface {
        /** @var DocumentInterface|PHPUnit_Framework_MockObject_MockObject $document */
        $document = $this->createMock(DocumentInterface::class);

        $document
            ->expects($this->once())
            ->method('getDateGenerated')
            ->willReturn($dateGenerated);

        $document
            ->expects($this->once())
            ->method('getDatePublished')
            ->willReturn($datePublished);

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
        $guard = new DocumentPublishedGuard();
        $this->assertTrue($expected === $guard->isRenderRequired($document));
    }
}
