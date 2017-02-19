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
                    $baseUrl = '/';

                    if (preg_match(
                        '|^github:/(/[^/]+/[^/]+/)(.+)$|',
                        $asset,
                        $matches
                    )) {
                        $baseUrl  = sprintf(
                            'https://raw.githubusercontent.com%s',
                            next($matches)
                        );
                        $asset    = next($matches);
                        $baseUrl .= sprintf(
                            '%s/',
                            $this->getAssetVersion($asset)
                        );
                    } else {
                        $asset .= sprintf(
                            '?%s',
                            $this->getAssetVersion($asset)
                        );
                    }

                    return $baseUrl . $asset;
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
