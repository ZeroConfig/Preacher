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
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Data\DataEnricherInterface;

class FooBarEnricher implements DataEnricherInterface
{
    /**
     * Enrich the template data using the given source and output.
     *
     * @param ArrayAccess     $templateData
     * @param SourceInterface $source
     * @param OutputInterface $output
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function enrich(
        ArrayAccess $templateData,
        SourceInterface $source,
        OutputInterface $output
    ) {
        $templateData->offsetSet('foo', 'bar');
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
