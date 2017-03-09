<?php
namespace ZeroConfig\Preacher;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use ZeroConfig\Preacher\DependencyInjection\Compiler\ContainerPass;
use ZeroConfig\Preacher\DependencyInjection\Compiler\EnricherPass;
use ZeroConfig\Preacher\DependencyInjection\Compiler\RenderGuardPass;
use ZeroConfig\Preacher\DependencyInjection\Compiler\SourceFilterPass;
use ZeroConfig\Preacher\DependencyInjection\Compiler\TwigExtensionPass;

/**
 * @codeCoverageIgnore
 */
class PreacherBundle extends Bundle
{
    /**
     * Container pass configuration.
     * <container>, <tag>, <method>
     *
     * @var string[][]
     */
    private $containerPasses = [
        // Filter out unwanted source files.
        ['preacher.source_iterator', 'preacher.source_filter', 'addFilter'],

        // Enrich template data.
        ['preacher.enricher', 'preacher.enricher', 'addEnricher'],

        // Add a Twig extension.
        ['preacher.twig', 'preacher.twig_extension', 'addExtension'],

        // Prevent documents from being rendered unnecessarily.
        ['preacher.generator.render_guard', 'preacher.render_guard', 'addGuard'],

        // Add a document feed generator.
        ['preacher.feed_generator', 'preacher.feed_generator', 'addGenerator']
    ];

    /**
     * Add compiler passes.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        foreach ($this->containerPasses as $passConfiguration) {
            $container->addCompilerPass(
                new ContainerPass(...$passConfiguration)
            );
        }
    }
}
