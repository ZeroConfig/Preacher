# Creating a custom source reader

One might want to use a different source for data, instead of Markdown.
Perhaps your favorite is [RST](http://docutils.sourceforge.net/rst.html) or you
want to apply the use of [Cyc](http://www.crockford.com/javascript/encyclopedia/)
for PHP, rather than JavaScript.

When looking at the granularity of Preacher, this is no problem at all, but a
couple of gotcha's might be overlooked.

![Regular Expressions](https://imgs.xkcd.com/comics/regular_expressions.png)

> Wait, forgot to escape a space.  Wheeeeee[taptaptap]eeeeee.

## Creating a custom plugin

To achieve this, one needs to create a
[custom Preacher plugin](custom-plugins.html) first.

## Creating a source filter

To create a custom source filter, one simply needs to implement the `FilterInterface`.

```php
<?php
use SplFileInfo;
use ZeroConfig\Preacher\Source\Filter\FilterInterface;

class ReStructuredTextFilter implements FilterInterface
{
    /**
     * Check whether the given file is allowed according to the current filter.
     *
     * @param SplFileInfo $file
     *
     * @return bool
     */
    public function isFileAllowed(SplFileInfo $file): bool
    {
        return $file->getExtension() === 'rst';
    }
}
```

## Replacing the Markdown source filter

To detect which files should be used to generate new output, Preacher uses source
filters, so only files matching all the filters will be allowed.

A number of filters are mandatory and as such are private services inside Preacher.
For instance, the GIT and Composer vendor filters. Or that the source is required
to be a file, instead of a directory.

But the Markdown source filter is a public service and can therefore be disabled.

Source filters are added through the `preacher.source_filter` tag.

In your plugin, add a compiler pass to remove the Markdown source filter and add
your own:

```php
<?php
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SourceFilterPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('preacher.source_iterator')) {
            return;
        }
        
        $iterator = $container->getDefinition('preacher.source_iterator');
    
        // Disable the Markdown filter.
        if ($container->hasDefinition('preacher.source_filter.markdown')) {
            $container
                ->getDefinition('preacher.source_filter.markdown')
                ->clearTag('preacher.source_filter');
        }

        // Add your own filter.
        // Add it directly instead of giving it a service tag, to ensure it will
        // be added first, to reduce calls on more complex filters.
        $iterator->addMethodCall('addFilter', [new Reference('my_filter')]);
    }
}
```

If you have trouble with the order in which the compiler pass is being executed,
try looking into
[controlling the pass ordering](http://symfony.com/doc/current/components/dependency_injection/compilation.html#controlling-the-pass-ordering).

You can ensure this is the case by increasing its priority like so:

```php
<?php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use My\AwesomeBundle\SourceFilterPass;

class AwesomeBundle extends Bundle
{
    /**
     * Add compiler passes.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new SourceFilterPass(),
            PassConfig::TYPE_BEFORE_OPTIMIZATION,
            10
        );
    }
}
```

The priority of the pass in Preacher is `0`, so by setting it to a value higher
than `0`, it will run before the pass in Preacher.

## Creating a source reader

```php
<?php
use ZeroConfig\Preacher\Renderer\SourceReaderInterface;
use ZeroConfig\Preacher\Source\SourceInterface;

class MySourceReader implements SourceReaderInterface
{
    /**
     * Get the contents of the given source.
     *
     * @param SourceInterface $source
     *
     * @return string
     */
    public function getContents(SourceInterface $source): string
    {
        // The source path will be relative to the current working directory.
        $contents = file_get_contents($source->getPath());
        
        // ... Process the contents to your liking ...
        
        return $contents;
    }
}
```

## Replacing the source reader

The source reader is a public service, bound to `preacher.source_reader`.

To replace the source reader, one simply needs to define a new service for that
identifier.

Below you see the implementation of the
[CommonMark plugin](https://github.com/ZeroConfig/Preacher-Plugin-CommonMark):

```yaml
services:

  preacher.common_mark.converter:
    class: League\CommonMark\CommonMarkConverter

  preacher.source_reader:
    class: ZeroConfig\Preacher\Plugin\CommonMark\Renderer\MarkdownSourceReader
    arguments:
      - '@preacher.common_mark.converter'
```
