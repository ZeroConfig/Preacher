<?php
namespace ZeroConfig\Preacher\Template;

use ZeroConfig\Preacher\Output\OutputInterface;

class TemplateFactory implements TemplateFactoryInterface
{
    /** @var TemplateLocatorInterface */
    private $locator;

    /**
     * Constructor.
     *
     * @param TemplateLocatorInterface $locator
     */
    public function __construct(TemplateLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Create a template for the given output.
     *
     * @param OutputInterface $output
     *
     * @return TemplateInterface
     */
    public function createTemplate(OutputInterface $output): TemplateInterface
    {
        return new Template(
            $this->locator->locateTemplate($output)
        );
    }
}
