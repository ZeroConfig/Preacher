<?php
namespace ZeroConfig\Preacher;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @codeCoverageIgnore
 */
class AppKernel extends Kernel
{
    /** @var string */
    private $homeDir;

    /**
     * Returns a list of bundles to register.
     *
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new PreacherBundle()
        ];
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader
     *
     * @return void
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config.yml');
    }

    /**
     * Get the root of the application.
     *
     * @return string
     */
    public function getRootDir(): string
    {
        if ($this->rootDir === null) {
            $this->rootDir = dirname(__DIR__);
        }

        return $this->rootDir;
    }

    /**
     * Get the home directory.
     *
     * @return string
     */
    private function getHomeDir(): string
    {
        if ($this->homeDir === null) {
            $this->homeDir = trim(`echo ~`);
        }

        return $this->homeDir;
    }

    /**
     * Get the cache directory.
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getHomeDir() . '/.preacher/var/cache';
    }

    /**
     * Get the log directory.
     *
     * @return string
     */
    public function getLogDir(): string
    {
        return $this->getHomeDir() . '/.preacher/var/logs';
    }
}
