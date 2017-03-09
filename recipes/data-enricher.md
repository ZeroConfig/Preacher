# Enriching template data

Preacher builds the data that is being sent to the template engine, by using
data enrichers. These enrichers can set additional data for the template, override
existing data or even unset data.

Removing data can hardly be called enrichment, however, the developer must judge
if this is really necessary. Just keep the following in mind:

![Workflow](https://imgs.xkcd.com/comics/workflow.png)

> There are probably children out there holding down spacebar to stay warm in the winter! YOUR UPDATE MURDERS CHILDREN.

# Adding an enricher

One can write an enricher by implementing the `DataEnricherInterface`:

```php
<?php
use ArrayAccess;
use ZeroConfig\Preacher\Document\DocumentInterface;
use ZeroConfig\Preacher\Data\DataEnricherInterface;

class FooBarEnricher implements DataEnricherInterface
{
    /**
     * Enrich the template data using the given source and output.
     *
     * @param ArrayAccess       $templateData
     * @param DocumentInterface $document
     *
     * @return void
     */
    public function enrich(
        ArrayAccess $templateData,
        DocumentInterface $document
    ) {
        $source = $document->getSource();
        $path   = sprintf(
            '%s/%s.custom',
            dirname($source->getPath()),
            $source->getBaseName()
        );
        
        $data = is_readable($path)
            ? file_get_contents($path)
            : '';
        
        $templateData->offsetSet('foo', $data);
    }
}
```

Then you can add the service and tag it with `preacher.enricher`.

```yaml
services:

  my_byndle.preacher.enricher.foobar:
    class: FooBarEnricher
    tags:
      - { name: 'preacher.enricher' }
```

We assume that the source file is `foo.md` and that the file `foo.custom` contains:

```
bar
```

Now, in the template, the following variable has become available:

```twig
<p>{{ foo }}</p>
```

And this will output:

```html
<p>bar</p>
```

To put this all in a reusable extension, read
[Creating a Preacher plugin](custom-plugins.html).

# Adding a render guard

To prevent preacher from rendering each and every file that can be matched, it
uses render guards that can tell when content is outdated.

When adding a data enricher, Preacher needs to be taught how to determine if the
data has been renewed.

```php
<?php
use ZeroConfig\Preacher\Generator\RenderGuard\RenderGuardInterface;
use ZeroConfig\Preacher\Document\DocumentInterface;

class FooBarGuard implements RenderGuardInterface
{
    /**
     * Tells whether a render is required for the given generator context.
     *
     * @param DocumentInterface $document
     *
     * @return bool
     */
    public function isRenderRequired(DocumentInterface $document): bool
    {
        $generated = $document->getOutput()->getMetaData()->getDateGenerated();
        $source    = $document->getSource();
        $file      = sprintf(
            '%s/%s.custom',
            dirname($source->getPath()),
            $source->getBaseName()
        );
        
        // Our custom file has been changed since last the output was generated.
        return (
            is_readable($file)
            && filemtime($file) > $generated->getTimestamp()
        );
    }
}
```

It is registered as a render guard.

```yaml
services:

  my_bundle.preacher.render_guard.foobar:
    class: FooBarGuard
    tags:
      - { name: 'preacher.render_guard' }
```
