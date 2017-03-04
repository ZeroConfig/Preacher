<?php
namespace ZeroConfig\Preacher;

/**
 * @codeCoverageIgnore
 */
final class Environment
{
    /** @var string */
    private $currentWorkingDirectory;

    /** @var string */
    private $homeDir;

    /** @var string */
    private $projectHash;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currentWorkingDirectory = getcwd();
        $this->homeDir                 = trim(`echo ~`);
        $this->projectHash             = sprintf(
            '%s-%s',
            sha1($this->currentWorkingDirectory),
            // Let changes to the service configuration invalidate cache.
            date(
                'Ymd-His',
                filemtime(__DIR__ . '/../config/services.yml')
            )
        );
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
     * Get the home directory.
     *
     * @return string
     */
    public function getHomeDir(): string
    {
        return $this->homeDir;
    }

    /**
     * Get the hash for the current project.
     *
     * @return string
     */
    public function getProjectHash(): string
    {
        return $this->projectHash;
    }

    /**
     * Get the cache directory.
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getHomeDir()
            . '/.preacher/var/cache/'
            . $this->getProjectHash();
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

    /**
     * Get the file for the plugin configuration.
     *
     * @return string
     */
    public function getPluginConfigurationFile(): string
    {
        return sprintf(
            '%s/.preacher/plugins/%s.php',
            $this->getHomeDir(),
            $this->getProjectHash()
        );
    }
}
