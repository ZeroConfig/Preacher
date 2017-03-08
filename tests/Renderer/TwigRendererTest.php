<?php
namespace ZeroConfig\Preacher\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use Twig_Environment;
use ZeroConfig\Preacher\Renderer\TwigRenderer;
use ZeroConfig\Preacher\Template\TemplateInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Renderer\TwigRenderer
 */
class TwigRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return TwigRenderer
     *
     * @covers ::__construct
     */
    public function testConstructor(): TwigRenderer
    {
        $twig = $this->createMock(Twig_Environment::class);

        $twig
            ->expects($this->any())
            ->method('render')
            ->with(
                $this->isType('string'),
                $this->isType('array')
            )
            ->willReturn(sha1(__FILE__));

        /** @noinspection PhpParamsInspection */
        return new TwigRenderer($twig);
    }

    /**
     * @depends testConstructor
     *
     * @param TwigRenderer $renderer
     *
     * @return string
     * @covers ::render
     */
    public function testRender(TwigRenderer $renderer): string
    {
        /** @noinspection PhpParamsInspection */
        return $renderer->render(
            $this->createMock(TemplateInterface::class),
            []
        );
    }
}
