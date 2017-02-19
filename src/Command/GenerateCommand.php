<?php
namespace ZeroConfig\Preacher\Command;

use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZeroConfig\Preacher\Generator\GeneratorInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\SourceInterface;
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
     * Configure the command.
     *
     * @return void
     */
    // @codeCoverageIgnoreStart
    // This would be testing Symfony.
    protected function configure()
    {
        $this->setDescription('Generate output files.');
        $this->addOption(
            'force',
            'f',
            InputOption::VALUE_NONE,
            'Force all (matching) sources to generate output.'
        );
        $this->addArgument(
            'source',
            InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
            'Source files to generate.'
        );
    }
    // @codeCoverageIgnoreEnd

    /**
     * Execute the generator for matching sources.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourcePatterns = $input->getArgument('source') ?: ['*'];
        $force          = $input->getOption('force');

        foreach ($this->sources as $source) {
            if (!$this->isMatchingSource($source, ...$sourcePatterns)) {
                continue;
            }

            $generated = $this->generator->generate($source, $force);

            if (!$generated instanceof UpdatedOutput) {
                continue;
            }

            $output->writeln(
                sprintf('<fg=green>Generated:</> %s', $generated->getPath())
            );
        }
    }

    /**
     * Whether the source matches the given list of patterns.
     *
     * @param SourceInterface $source
     * @param string[]       ...$patterns
     *
     * @return bool
     */
    private function isMatchingSource(
        SourceInterface $source,
        string ...$patterns
    ): bool {
        return array_reduce(
            $patterns,
            function (bool $memo, string $pattern) use ($source) : bool {
                return $memo || fnmatch($pattern, $source->getPath());
            },
            false
        );
    }
}
