<?php
namespace ZeroConfig\Preacher\Tests\Document;

use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentFactory;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Document\DocumentFactory
 */
class DocumentFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return DocumentFactory
     *
     * @covers ::__construct
     */
    public function testConstructor(): DocumentFactory
    {
        /** @noinspection PhpParamsInspection */
        return new DocumentFactory(
            $this->createMock(OutputFactoryInterface::class),
            $this->createMock(TemplateFactoryInterface::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param DocumentFactory $factory
     *
     * @return DocumentInterface
     * @covers ::createDocument
     */
    public function testCreateDocument(
        DocumentFactory $factory
    ): DocumentInterface {
        /** @noinspection PhpParamsInspection */
        return $factory->createDocument(
            $this->createMock(SourceInterface::class)
        );
    }
}
