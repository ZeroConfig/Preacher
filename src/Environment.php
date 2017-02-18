<?php
namespace ZeroConfig\Preacher;

use Composer\Config;
use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Coyl\Git\Git;
use Coyl\Git\GitRepo;
use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Twig_Loader_Filesystem;
use Twig_LoaderInterface;
use ZeroConfig\Preacher\Source\MetaDataFactoryInterface;
use ZeroConfig\Preacher\Source\SourceFactory;
use ZeroConfig\Preacher\Source\SourceFactoryInterface;
use ZeroConfig\Preacher\Template\TemplateLocator;
use ZeroConfig\Preacher\Template\TemplateLocatorInterface;

/**
 * @codeCoverageIgnore
 */
final class Environment
{
    /** @var string */
    private $currentWorkingDirectory;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currentWorkingDirectory = getcwd();
    }

    /**
     * Get the current working directory.
     *
     * @return string
     */
    public function getCurrentWorkingDirectory(): string
    {
        return $this->currentWorkingDirectory;
    }

    /**
     * Get the file relative to the working directory.
     *
     * @param string $file
     *
     * @return string
     */
    public function getFile(string $file): string
    {
        return $this->getCurrentWorkingDirectory()
            . DIRECTORY_SEPARATOR
            . $file;
    }

    /**
     * Create a template locator.
     *
     * @param string $default
     * @param string $extension
     *
     * @return TemplateLocatorInterface
     */
    public function createTemplateLocator(
        string $default,
        string $extension
    ): TemplateLocatorInterface {
        return new TemplateLocator(
            $this->getFile($default),
            $extension
        );
    }

    /**
     * Create a Twig loader for the current working directory.
     *
     * @return Twig_LoaderInterface
     */
    public function createTwigLoader(): Twig_LoaderInterface
    {
        return new Twig_Loader_Filesystem([
            $this->getCurrentWorkingDirectory()
        ]);
    }

    /**
     * Get the git repository for the current working directory.
     *
     * @return GitRepo
     */
    public function createRepository(): GitRepo
    {
        return Git::open($this->getCurrentWorkingDirectory());
    }

    /**
     * Get the composer configuration for the current working directory.
     *
     * @param string $file
     *
     * @return Config
     */
    public function createComposerConfig(string $file): Config
    {
        $config = new Config(true, $this->getCurrentWorkingDirectory());

        $config->setConfigSource(
            new JsonConfigSource(
                new JsonFile(
                    $this->getFile($file)
                )
            )
        );

        return $config;
    }

    /**
     * Create a recursive file iterator for the given path.
     *
     * @param string $path
     *
     * @return Iterator
     */
    public function createFileIterator(string $path = ''): Iterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->getFile($path)
            )
        );
    }

    /**
     * Create a source factory.
     *
     * @param MetaDataFactoryInterface $factory
     *
     * @return SourceFactoryInterface
     */
    public function createSourceFactory(
        MetaDataFactoryInterface $factory
    ): SourceFactoryInterface {
        return new SourceFactory($factory, $this->getCurrentWorkingDirectory());
    }
}
