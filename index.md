# Static website generator

Preacher is a static website generator, written in PHP.
It requires no configuration of the software itself. Simply write Markdown,
a Twig template or two and enjoy your personal site.

![The general problem](https://imgs.xkcd.com/comics/the_general_problem.png)

> I find that when someone's taking time to do something right in the present, they're a perfectionist with no ability to prioritize, whereas when someone took time to do something right in the past, they're a master artisan of great foresight.

# How to preach

After [installing Preacher](README.html), one only needs to commit their source
files to activate Preacher.

![Post commit hook](https://zeroconfig.github.io/Preacher/img/post-commit.png)

The following steps are executed:

1. Update source file
2. Commit source file > Output generates
3. Commit output file

Try `vendor/bin/preach --help` to see how to run Preacher manually.

# Preacher for writers

* [Getting started](README.html)
* [Template data](recipes/template-data.html)
* [GitHub Flavored Markdown](recipes/github-flavored-markdown.html)
* [Creating drafts](recipes/draft.html)
* [Adding Microdata to your site](recipes/microdata.html)
* [Managing asset cache](recipes/asset-cache.html)

# Preacher for developers

* [Creating a Preacher plugin](recipes/custom-plugins.html)
* [Enriching template data](recipes/data-enricher.html)
* [Syndication feed](recipes/feed-generator.html)
* [Extending Twig](recipes/extending-twig.html)
* [Swapping out Markdown](recipes/custom-source-reader.html)
