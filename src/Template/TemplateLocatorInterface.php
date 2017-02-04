<?php
namespace ZeroConfig\Preacher\Template;

use ZeroConfig\Preacher\Output\OutputInterface;

interface TemplateLocatorInterface
{
    /**
     * Get the template path for the given output.
     *
     * @param OutputInterface $output
     *
     * @return string
     */
    public function locateTemplate(OutputInterface $output): string;
}
