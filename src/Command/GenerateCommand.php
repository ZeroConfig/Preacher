<?php
namespace ZeroConfig\Preacher\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZeroConfig\Preacher\Generator\GeneratorInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceIteratorInterface;

class GenerateCommand extends Command
{
    /** @var SourceIteratorInterface */
    private $sources;

    /** @var GeneratorInterface */
    private $generator;

    /**
     * Constructor.
     *
     * @param SourceIteratorInterface $sources
     * @param GeneratorInterface      $generator
     */
    public function __construct(
        SourceIteratorInterface $sources,
        GeneratorInterface $generator
    ) {
        parent::__construct('preacher:generate');
        $this->sources   = $sources;
        $this->generator = $generator;
    }

    /**
     * Execute the generator for matching sources.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->sources as $source) {
            $generated = $this->generator->generate($source);

            if (!$generated instanceof UpdatedOutput) {
                continue;
            }

            $output->writeln(
                sprintf('<fg=green>Generated:</> %s', $generated->getPath())
            );
        }
    }
}
