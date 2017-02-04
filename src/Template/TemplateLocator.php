<?php
namespace ZeroConfig\Preacher\Template;

use ZeroConfig\Preacher\Output\OutputInterface;

class TemplateLocator implements TemplateLocatorInterface
{
    /** @var string */
    private $defaultTemplate;

    /** @var string */
    private $extension;

    /**
     * Constructor.
     *
     * @param string $defaultTemplate
     * @param string $extension
     *
     * @throws MissingTemplateException When the default template does not exist.
     */
    public function __construct($defaultTemplate, $extension = 'twig')
    {
        if (!is_readable($defaultTemplate)) {
            throw new MissingTemplateException(
                sprintf('Missing template file: "%s"', $defaultTemplate)
            );
        }

        $this->defaultTemplate = $defaultTemplate;
        $this->extension       = '.' . ltrim($extension, '.');
    }

    /**
     * Get the template path for the given output.
     *
     * @param OutputInterface $output
     *
     * @return string
     */
    public function locateTemplate(OutputInterface $output): string
    {
        $path = $output->getPath() . $this->extension;

        return is_readable($path)
            ? $path
            : $this->defaultTemplate;
    }
}
