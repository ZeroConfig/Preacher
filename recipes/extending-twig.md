# Extending Twig

> The main motivation for writing an extension is to move often used code into a reusable class like adding support for internationalization. An extension can define tags, filters, tests, operators, global variables, functions, and node visitors.

Writing a Twig extension for Preacher is the same as you are used to for Symfony.
Have a look at
[How to Write a custom Twig Extension](http://symfony.com/doc/current/templating/twig_extension.html)
if you are unfamiliar with writing your own extension.

Whenever the Symfony documentation references to the tag `twig.extension`,
Preacher expects the tag `preacher.twig_extension` to keep it decoupled from
the Symfony Framework.

The extension should be written inside a [Preacher plugin](custom-plugins.html).

![Genetic Analysis](https://imgs.xkcd.com/comics/genetic_analysis.png)

> There's still a chance you were conceived via IVF. But we've checked your mom's college yearbook photos, and whether or not she and your father had sex, it's clear that ... listen, I know this is hard for you.
