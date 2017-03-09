<?php
namespace ZeroConfig\Preacher\Renderer;

use ArrayObject;
use Twig_Environment;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

class TwigRenderer implements RendererInterface
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * Constructor.
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Render the given template using the given data.
     *
     * @param TemplateInterface $template
     * @param array             $data
     *
     * @return string
     */
    public function render(TemplateInterface $template, array $data): string
    {
        return $this->twig->render($template->getPath(), $data);
    }
}
