# Template data

Preacher uses version control and environment settings to provide the template
engine with the following data:

| Attribute               | Template call                                           | Example                                  |
|:------------------------|:--------------------------------------------------------|:-----------------------------------------|
| Author name             | `{{ source.metaData.author.name }}`                     | Jan-Marten de Boer                       |
| Author email            | `{{ source.metaData.author.email }}`                    | preacher@johmanx.com                     |
| Commit reference        | `{{ source.metaData.version }}`                         | fce8b0a0b1fa5f986282b51eb4824b3983c1e6e8 |
| Short commit reference  | `{{ source.metaData.version.short }}`                   | fce8b0a                                  |
| Date created            | `{{ source.metaData.dateCreated|date("Y-m-d H:i") }}`   | 2017-02-04 13:37                         |
| Date updated            | `{{ source.metaData.dateUpdated|date("Y-m-d H:i") }}`   | 2017-02-05 00:42                         |
| Date published          | `{{ output.metaData.datePublished|date("Y-m-d H:i") }}` | 2017-02-05 00:45                         |
| Date generated          | `{{ output.metaData.dateGenerated|date("Y-m-d H:i") }}` | 2017-02-05 00:47                         |
| Number of revisions     | `{{ source.metaData.numRevisions }}`                    | 2                                        |
| Basename of source      | `{{ source.baseName }}`                                 | index                                    |
| Path to source          | `{{ source.path }}`                                     | index.md                                 |
| Path to output          | `{{ output.path }}`                                     | index.html                               |
| Path to template        | `{{ template.path }}`                                   | default.html.twig                        |
| Generated content       | `{{ content }}`                                         | `<h1>My great adventure</h1><p>Lorum...` |
| Headline                | `{{ headline }}`                                        | My great adventure                       |

## Defining a title

To create a title for your page, it is practical to reuse the headline of your
page. However, not all pages require a headline.

Therefore, the following recipe may come in handy:

```twig
<title>{{ headline|default(source.baseName) }} - My awesome website</title>
```

This way, when there is a headline, that will be used. Otherwise it will revert
to the basename of your source file.

I.e.: `random/Funnies.md` => `Funnies`.

See the [default filter](http://twig.sensiolabs.org/doc/2.x/filters/default.html)
documentation for more information.

## Canonical links

For search engine optimization, websites commonly set a
[canonical URL](https://support.google.com/webmasters/answer/139066?hl=en) for
their pages.

The one for this page is as follows:

```twig
<link rel="canonical" href="https://zeroconfig.github.io/Preacher/{{ output.path }}" />
```

## Edit this page on GitHub

To create a link that allows you to edit the current page on GitHub, try the
following recipe:

```twig
<a href="https://github.com/ZeroConfig/Preacher/edit/master/{{ source.path }}">
    Edit this page
</a>
```

## Current revision

To create a link that allows you to see the last change on the current page, try
the following recipe:

```twig
<a href="https://github.com/ZeroConfig/Preacher/blob/{{ source.metaData.version.short }}/{{ source.path }}">
    Show latest revision
</a>
```

## Revision history

To see a list of all revisions, one can use the following:

```twig
<a href="https://github.com/ZeroConfig/Preacher/commits/{{ source.metaData.version.short }}/{{ source.path }}">
    Show revision history
</a>
```
