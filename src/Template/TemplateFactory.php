<?php
namespace ZeroConfig\Preacher\Template;

use Coyl\Git\GitRepo;
use DateTimeImmutable;
use ZeroConfig\Preacher\Output\OutputInterface;

class TemplateFactory implements TemplateFactoryInterface
{
    /** @var TemplateLocatorInterface */
    private $locator;

    /** @var GitRepo */
    private $repository;

    /**
     * Constructor.
     *
     * @param TemplateLocatorInterface $locator
     * @param GitRepo                  $repository
     */
    public function __construct(
        TemplateLocatorInterface $locator,
        GitRepo $repository
    ) {
        $this->locator    = $locator;
        $this->repository = $repository;
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
        $file = $this->locator->locateTemplate($output);

        return new Template(
            $file,
            new DateTimeImmutable(
                $this->repository->logFormatted('%aD', $file, 1)
            )
        );
    }
}
