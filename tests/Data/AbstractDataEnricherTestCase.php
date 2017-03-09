<?php
namespace ZeroConfig\Preacher\Tests\Data;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ZeroConfig\Preacher\Document\DocumentInterface;

class AbstractDataEnricherTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return PHPUnit_Framework_MockObject_MockObject|DocumentInterface
     */
    protected function createDocument()
    {
        return $this->createMock(DocumentInterface::class);
    }
}
