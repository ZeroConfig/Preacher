<?php
namespace ZeroConfig\Preacher\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZeroConfig\Preacher\Document\DocumentFeedInterface;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Feed\FeedGeneratorInterface;
use ZeroConfig\Preacher\Generator\GeneratorInterface;
use ZeroConfig\Preacher\Generator\RenderGuard\RenderGuardInterface;

/**
 * @codeCoverageIgnore
 */
class GenerateCommand extends Command
{
    /** @var DocumentFeedInterface */
    private $documents;

    /** @var RenderGuardInterface */
    private $renderGuard;

    /** @var GeneratorInterface */
    private $generator;

    /** @var FeedGeneratorInterface */
    private $feedGenerator;

    /**
     * Constructor.
     *
     * @param DocumentFeedInterface  $documents
     * @param RenderGuardInterface   $renderGuard
     * @param GeneratorInterface     $generator
     * @param FeedGeneratorInterface $feedGenerator
     */
    public function __construct(
        DocumentFeedInterface $documents,
        RenderGuardInterface $renderGuard,
        GeneratorInterface $generator,
        FeedGeneratorInterface $feedGenerator
    ) {
        $this->documents     = $documents;
        $this->renderGuard   = $renderGuard;
        $this->generator     = $generator;
        $this->feedGenerator = $feedGenerator;
        parent::__construct('preacher:generate');
    }

    /**
     * Configure the command.
     *
     * @return void
     */
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
            'Source files to generate.',
            ['*']
        );
    }

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
        $sourcePatterns     = $input->getArgument('source');
        $force              = $input->getOption('force');
        $feedRequiresUpdate = $force;

        foreach ($this->documents as $document) {
            if (!$this->isMatchingDocument($document, ...$sourcePatterns)) {
                continue;
            }

            if ($force === false
                && $this->renderGuard->isRenderRequired($document) === false
            ) {
                continue;
            }

            $this->generator->generate($document);
            $feedRequiresUpdate = true;

            $output->writeln(
                sprintf(
                    '<fg=green>Generated:</> %s',
                    $document->getOutput()->getPath()
                )
            );
        }

        if ($feedRequiresUpdate) {
            $this->feedGenerator->generateFeed($this->documents);
            $output->writeln('<info>Feeds have been updated</info>');
        }
    }

    /**
     * Whether the source matches the given list of patterns.
     *
     * @param DocumentInterface $document
     * @param string[]          ...$patterns
     *
     * @return bool
     */
    private function isMatchingDocument(
        DocumentInterface $document,
        string ...$patterns
    ): bool {
        $source = $document->getSource();

        return array_reduce(
            $patterns,
            function (bool $memo, string $pattern) use ($source) : bool {
                return $memo || fnmatch($pattern, $source->getPath());
            },
            false
        );
    }
}
