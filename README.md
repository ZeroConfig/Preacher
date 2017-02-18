# Introduction

Preacher is a personal static website generator, which allows you to setup and
maintain a personal website with zero configuration.

![I always figured the word 'blog' would sound *less* silly as the years went by.](https://imgs.xkcd.com/comics/starwatching.png)

# Installation

```bash
composer require --dev zero-config/preacher
```

Optionally, if one wants to always generate output when a file is committed, try
the following:

```bash
ln -s vendor/bin/preach .git/hooks/post-commit
```

This will install preacher as a post-commit hook and makes it run each time you
commit one of your files.

# Usage

It uses a single command to either generate the current directory and all its
children or one can (re)generate a single source file.

```bash
vendor/bin/preach [<source>]...
```

The contents of vendor directories are skipped by interpreting the
[vendor-dir composer config](https://getcomposer.org/doc/06-config.md#vendor-dir).

If one wants to force the generation of files, add the `--force` flag.

# Standards

Preacher uses existing software with well-defined standards to create the most
stable and user friendly experience at the same time.

Preacher is built with programmers in mind.

| Component          | Type                                                                                                        | Package                                                   |
|:-------------------|:------------------------------------------------------------------------------------------------------------|:----------------------------------------------------------|
| Content parser     | [GitHub Flavored Markdown](https://guides.github.com/features/mastering-markdown/#GitHub-flavored-markdown) | [erusev/parsedown](http://parsedown.org/)                 |
| Template engine    | [Twig 2](http://twig.sensiolabs.org/)                                                                       | [twig/twig](https://packagist.org/packages/twig/twig)     |
| Version control    | [git](https://git-scm.com/)                                                                                 | [coyl/git](https://github.com/coyl/git)                   |
| Package manager    | [Composer](https://getcomposer.org/)                                                                        | [composer/composer](https://github.com/composer/composer) |
| Syntax highlighter | [Prism](http://prismjs.com/)                                                                                | [prismjs](https://www.npmjs.com/package/prismjs)          |

# Template data

Preacher uses version control and environment settings to provide the template
engine with the following data:

| Attribute               | Template call                                              | Example                                  |
|:------------------------|:-----------------------------------------------------------|:-----------------------------------------|
| Author name             | {{ source.metaData.author.name }}                          | Jan-Marten de Boer                       |
| Author email            | {{ source.metaData.author.email }}                         | preacher@johmanx.com                     |
| Commit reference        | {{ source.metaData.version }}                              | fce8b0a0b1fa5f986282b51eb4824b3983c1e6e8 |
| Short commit reference  | {{ source.metaData.version.short }}                        | fce8b0a                                  |
| Date created            | {{ source.metaData.dateCreated&#124;date("Y-m-d H:i") }}   | 2017-02-04 13:37                         |
| Date updated            | {{ source.metaData.dateUpdated&#124;date("Y-m-d H:i") }}   | 2017-02-05 00:42                         |
| Date published          | {{ output.metaData.datePublished&#124;date("Y-m-d H:i") }} | 2017-02-05 00:45                         |
| Date generated          | {{ output.metaData.dateGenerated&#124;date("Y-m-d H:i") }} | 2017-02-05 00:47                         |
| Number of revisions     | {{ source.metaData.numRevisions }}                         | 2                                        |
| Basename of source      | {{ source.baseName }}                                      | index                                    |
| Path to source          | {{ source.path }}                                          | index.md                                 |
| Path to output          | {{ output.path }}                                          | index.html                               |
| Path to template        | {{ template.path }}                                        | default.html.twig                        |
| Generated content       | {{ content }}                                              | `<h1>My great adventure</h1><p>Lorum...` |
| Headline                | {{ headline }}                                             | My great adventure                       |

# Custom templates

By default, Preacher will look for the Twig template called `default.html.twig`.
However, if a custom template is required, simply give it the same name as the
source file.

E.g.: `articles/something-fancy.md` => `articles/something-fancy.html.twig`.

# Enabling Github Flavored Markdown

To use code syntax highlighting, one can choose a
[Prism theme package](http://prismjs.com/download.html).

Download a package and add it to your template:

```html
<link href="prism.css" rel="stylesheet" type="text/css" />
<script src="prism.js" type="text/javascript"></script>
```

The result will be a highlighted syntax for your code blocks.

```php
<?php
// Do not forget to open your PHP script with the open tag.
$this->is('awesome');
```

For more information on writing code blocks, please read up on
[GitHub Flavored Markdown](https://guides.github.com/features/mastering-markdown/#GitHub-flavored-markdown).

