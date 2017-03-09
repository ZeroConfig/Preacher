<?php
namespace ZeroConfig\Preacher\Tests\Document;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use ZeroConfig\Preacher\Document\Document;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Document\Document
 */
class DocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $interface
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createDateAwareMock(
        string $interface
    ): PHPUnit_Framework_MockObject_MockObject {
        $mock = $this->createMock($interface);
        $this->augmentDateGetterExpectation($mock);

        $reflection = new ReflectionClass($interface);

        if ($reflection->hasMethod('getMetaData')) {
            $method   = $reflection->getMethod('getMetaData');
            $metaData = $this->createMock((string)$method->getReturnType());

            $mock
                ->expects($this->any())
                ->method('getMetaData')
                ->willReturn(
                    $this->augmentDateGetterExpectation($metaData)
                );
        }

        return $mock;
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $mock
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function augmentDateGetterExpectation(
        PHPUnit_Framework_MockObject_MockObject $mock
    ): PHPUnit_Framework_MockObject_MockObject {
        $mock
            ->expects($this->any())
            ->method(
                $this->matchesRegularExpression('/^getDate\w+$/')
            )
            ->willReturn(
                new DateTimeImmutable('yesterday')
            );

        return $mock;
    }

    /**
     * @return Document
     *
     * @covers ::__construct
     */
    public function testConstructor(): Document
    {
        /** @noinspection PhpParamsInspection */
        return new Document(
            $this->createDateAwareMock(SourceInterface::class),
            $this->createDateAwareMock(OutputInterface::class),
            $this->createDateAwareMock(TemplateInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return SourceInterface
     * @covers ::getSource
     */
    public function testGetSource(Document $document): SourceInterface
    {
        return $document->getSource();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return TemplateInterface
     * @covers ::getTemplate
     */
    public function testGetTemplate(Document $document): TemplateInterface
    {
        return $document->getTemplate();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return OutputInterface
     * @covers ::getOutput
     */
    public function testGetOutput(Document $document): OutputInterface
    {
        return $document->getOutput();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return DateTimeInterface
     * @covers ::getDateCreated
     */
    public function testGetDateCreated(Document $document): DateTimeInterface
    {
        return $document->getDateCreated();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return DateTimeInterface
     * @covers ::getDatePublished
     */
    public function testGetDatePublished(Document $document): DateTimeInterface
    {
        return $document->getDatePublished();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return DateTimeInterface
     * @covers ::getDateGenerated
     */
    public function testGetDateGenerated(Document $document): DateTimeInterface
    {
        return $document->getDateGenerated();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return DateTimeInterface
     * @covers ::getDateSourceUpdated
     */
    public function testGetDateSourceUpdated(Document $document): DateTimeInterface
    {
        return $document->getDateSourceUpdated();
    }

    /**
     * @depends testConstructor
     *
     * @param Document $document
     *
     * @return DateTimeInterface
     * @covers ::getDateTemplateUpdated
     */
    public function testGetDateTemplateUpdated(Document $document): DateTimeInterface
    {
        return $document->getDateTemplateUpdated();
    }

    /**
     * @depends clone testConstructor
     *
     * @param Document $document
     *
     * @return OutputInterface|UpdatedOutput
     * @covers ::updateOutput
     */
    public function testUpdateOutput(Document $document): UpdatedOutput
    {
        $this->assertNotInstanceOf(
            UpdatedOutput::class,
            $document->getOutput()
        );

        $document->updateOutput();

        return $document->getOutput();
    }
}
