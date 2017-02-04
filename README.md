# Introduction

Preacher is a personal static website generator, which allows you to setup and
maintain a personal website with zero configuration.
It uses version control and environment settings to provide the template engine
with meta data, like:

* Author name
* Author email
* Commit reference
* Short commit reference
* Date created
* Date updated
* Date generated
* Path to source file
* Path to generated file

It uses a single command to either generate the current directory and all its
children or one can (re)generate a single source file.

```shell
vendor/bin/preach [<path/to/file.md>]
```

If the path is a directory, its contents will be recursively generated, until
the deepest leaf file has been reached.

# Standards

Preacher uses existing software with well-defined standards to create the most
stable and user friendly experience at the same time.

Preacher is built with programmers in mind.

| Component       | Type                                                                                                        | Package                                                   |
|:----------------|:------------------------------------------------------------------------------------------------------------|:----------------------------------------------------------|
| Content parser  | [Github Flafored Markdown](https://guides.github.com/features/mastering-markdown/#GitHub-flavored-markdown) | [erusev/parsedown](http://parsedown.org/)                 |
| Template engine | [Twig 2](http://twig.sensiolabs.org/)                                                                       | [twig/twig](https://packagist.org/packages/twig/twig)     |
| Version control | [git](https://git-scm.com/)                                                                                 | [coyl/git](https://github.com/coyl/git) |
