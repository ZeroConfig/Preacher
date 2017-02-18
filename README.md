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

# Custom templates

By default, Preacher will look for the Twig template called `default.html.twig`.
However, if a custom template is required, simply give it the same name as the
source file.

E.g.: `articles/something-fancy.md` => `articles/something-fancy.html.twig`.


# Documentation

For full documentation and a cookbook for Preacher, go to
[the Preacher homepage](https://zeroconfig.github.io/Preacher/).
