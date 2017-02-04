<?php
namespace ZeroConfig\Preacher\Template;

use ZeroConfig\Preacher\Output\OutputInterface;

interface TemplateFactoryInterface
{
    /**
     * Create a template for the given output.
     *
     * @param OutputInterface $output
     *
     * @return TemplateInterface
     */
    public function createTemplate(OutputInterface $output): TemplateInterface;
}
