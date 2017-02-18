<?php
namespace ZeroConfig\Preacher\Source\Filter;

use Composer\Config;
use SplFileInfo;

class ComposerFilter implements FilterInterface
{
    /** @var string */
    private $vendorDirectory;

    /**
     * Constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->vendorDirectory = $config->get('vendor-dir');
    }

    /**
     * Check whether the given file is allowed according to the current filter.
     *
     * @param SplFileInfo $file
     *
     * @return bool
     */
    public function isFileAllowed(SplFileInfo $file): bool
    {
        return strpos($file->getRealPath(), $this->vendorDirectory) !== 0;
    }
}
