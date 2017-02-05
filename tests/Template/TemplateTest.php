<?php


namespace ZeroConfig\Preacher\Tests\Template;

use DateTimeImmutable;
use DateTimeInterface;
use ZeroConfig\Preacher\Template\Template;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Template\Template
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Template
     * @covers ::__construct
     */
    public function testConstructor(): Template
    {
        /** @noinspection PhpParamsInspection */
        return new Template(
            'foo',
            $this->createMock(DateTimeImmutable::class)
        );
    }

    /**
     * @depends testConstructor
     *
     * @param Template $template
     *
     * @return string
     * @covers ::getPath
     */
    public function testGetPath(Template $template): string
    {
        return $template->getPath();
    }

    /**
     * @depends testConstructor
     *
     * @param Template $template
     *
     * @return DateTimeInterface
     * @covers ::getDateUpdated
     */
    public function testGetDateUpdated(Template $template): DateTimeInterface
    {
        return $template->getDateUpdated();
    }
}
