<?php
namespace ZeroConfig\Preacher\Twig;

use Coyl\Git\GitRepo;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * @codeCoverageIgnore
 */
class AssetExtension extends Twig_Extension
{
    /**
     * @var GitRepo
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param GitRepo $repository
     */
    public function __construct(GitRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the functions for the current extension.
     *
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction(
                'asset',
                function (string $asset) : string {
                    return sprintf(
                        '%s?%s',
                        $asset,
                        $this->getAssetVersion($asset)
                    );
                }
            )
        ];
    }

    /**
     * Get the version for the given asset.
     *
     * @param string $asset
     *
     * @return string
     */
    private function getAssetVersion(string $asset): string
    {
        return $this
            ->repository
            ->logFormatted('%h', $asset, 1) ?: 'v1';
    }
}
