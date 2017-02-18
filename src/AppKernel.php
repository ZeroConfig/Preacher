<?php
namespace ZeroConfig\Preacher;

use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Throwable;

/**
 * @codeCoverageIgnore
 */
class AppKernel extends Kernel
{
    /** @var Environment */
    private $preacherEnvironment;

    /**
     * Get the preacher environment.
     *
     * @return Environment
     */
    private function getPreacherEnvironment(): Environment
    {
        if ($this->preacherEnvironment === null) {
            $this->preacherEnvironment = new Environment();
        }

        return $this->preacherEnvironment;
    }

    /**
     * Returns a list of bundles to register.
     *
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return array_merge(
            [
                new FrameworkBundle(),
                new PreacherBundle()
            ],
            $this->getPluginBundles()
        );
    }

    /**
     * Return a list of Preacher plugin bundles.
     *
     * @return BundleInterface[]
     */
    private function getPluginBundles(): array
    {
        $bundles = [];

        foreach ($this->getPluginClasses() as $pluginClass) {
            try {
                $reflection = new ReflectionClass($pluginClass);
            } catch (ReflectionException $e) {
                continue;
            }

            if ($reflection->getConstructor()
                && $reflection->getConstructor()->getNumberOfRequiredParameters()
            ) {
                continue;
            }

            if (!$reflection->implementsInterface(BundleInterface::class)) {
                continue;
            }

            if ($reflection->isAbstract()) {
                continue;
            }

            try {
                $bundles[] = $reflection->newInstance();
            } catch (Throwable $e) {
                continue;
            }
        }

        return $bundles;
    }

    /**
     * Get the plugin classes for the current working directory.
     *
     * @return string[]
     */
    private function getPluginClasses(): array
    {
        $configurationFile = $this
            ->getPreacherEnvironment()
            ->getPluginConfigurationFile();

        /** @noinspection PhpIncludeInspection */
        return file_exists($configurationFile)
            ? include $configurationFile
            : [];
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
     * Get the cache directory.
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getPreacherEnvironment()->getCacheDir();
    }

    /**
     * Get the log directory.
     *
     * @return string
     */
    public function getLogDir(): string
    {
        return $this->getPreacherEnvironment()->getLogDir();
    }
}
