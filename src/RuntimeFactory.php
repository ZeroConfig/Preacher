<?php
namespace ZeroConfig\Preacher;

use Composer\Config;
use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Coyl\Git\GitRepo;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Twig_Loader_Filesystem;
use ZeroConfig\Preacher\Source\MetaDataFactoryInterface;
use ZeroConfig\Preacher\Source\SourceFactory;
use ZeroConfig\Preacher\Template\TemplateLocator;

/**
 * @codeCoverageIgnore
 */
final class RuntimeFactory
{
    /** @var Environment */
    private $environment;

    /**
     * Constructor.
     *
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Create a template locator.
     *
     * @param string $default
     * @param string $extension
     *
     * @return TemplateLocator
     */
    public function createTemplateLocator(
        string $default,
        string $extension
    ): TemplateLocator {
        return new TemplateLocator(
            $this->environment->getFile($default),
            $extension
        );
    }

    /**
     * Create a Twig loader for the current working directory.
     *
     * @return Twig_Loader_Filesystem
     */
    public function createTwigLoader(): Twig_Loader_Filesystem
    {
        return new Twig_Loader_Filesystem([
            $this->environment->getCurrentWorkingDirectory()
        ]);
    }

    /**
     * Get the git repository for the current working directory.
     *
     * @return GitRepo
     */
    public function createRepository(): GitRepo
    {
        return new GitRepo($this->environment->getCurrentWorkingDirectory());
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
        $config = new Config(
            true,
            $this->environment->getCurrentWorkingDirectory()
        );

        $config->setConfigSource(
            new JsonConfigSource(
                new JsonFile(
                    $this->environment->getFile($file)
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
     * @return RecursiveIteratorIterator
     */
    public function createFileIterator(
        string $path = ''
    ): RecursiveIteratorIterator {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->environment->getFile($path)
            )
        );
    }

    /**
     * Create a source factory.
     *
     * @param MetaDataFactoryInterface $factory
     *
     * @return SourceFactory
     */
    public function createSourceFactory(
        MetaDataFactoryInterface $factory
    ): SourceFactory {
        return new SourceFactory(
            $factory,
            $this->environment->getCurrentWorkingDirectory()
        );
    }
}
