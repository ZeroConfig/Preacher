# Introduction

Preacher is a personal static website generator, which allows you to setup and
maintain a personal website with zero configuration.

# Installation

```shell
composer require --dev zero-config/preacher
```

# Usage

It uses a single command to either generate the current directory and all its
children or one can (re)generate a single source file.

```shell
vendor/bin/preach [<path/to/file.md>]
```

If the path is a directory, its contents will be recursively generated, until
the deepest leaf file has been reached.

The contents of vendor directories are skipped by interpreting the
[vendor-dir composer config](https://getcomposer.org/doc/06-config.md#vendor-dir).

# Standards

Preacher uses existing software with well-defined standards to create the most
stable and user friendly experience at the same time.

Preacher is built with programmers in mind.

| Component       | Type                                                                                                        | Package                                                   |
|:----------------|:------------------------------------------------------------------------------------------------------------|:----------------------------------------------------------|
| Content parser  | [Github Flafored Markdown](https://guides.github.com/features/mastering-markdown/#GitHub-flavored-markdown) | [erusev/parsedown](http://parsedown.org/)                 |
| Template engine | [Twig 2](http://twig.sensiolabs.org/)                                                                       | [twig/twig](https://packagist.org/packages/twig/twig)     |
| Version control | [git](https://git-scm.com/)                                                                                 | [coyl/git](https://github.com/coyl/git)                   |
| Package manager | [Composer](https://getcomposer.org/)                                                                        | [composer/composer](https://github.com/composer/composer) |

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
| Date updated            | {{ source.metaData.dateCreated&#124;date("Y-m-d H:i") }}   | 2017-02-05 00:42                         |
| Date published          | {{ output.metaData.datePublished&#124;date("Y-m-d H:i") }} | 2017-02-05 00:45                         |
| Date generated          | {{ output.metaData.dateGenerated&#124;date("Y-m-d H:i") }} | 2017-02-05 00:47                         |
| Number of revisions     | {{ source.metaData.numRevisions }}                         | 2                                        |
| Path to source          | {{ source.path }}                                          | index.md                                 |
| Path to output          | {{ output.path }}                                          | index.html                               |
| Path to template        | {{ template.path }}                                        | default.html.twig                        |
| Generated content       | {{ content }}                                              | `<html><head><title>...`                 |

# Enabling Github Flavored Markdown

To use code syntax highlighting, the following needs to be added to your template.

```html
<link href="http://parsedown.org/prism.css" rel="stylesheet" type="text/css" />
<script src="http://parsedown.org/prism.js" type="text/javascript"></script>
```

```php
<?php
// Do not forget to open your PHP script with the open tag.
$this->is('awesome');
```
