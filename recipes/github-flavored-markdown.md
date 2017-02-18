# Enabling Github Flavored Markdown

> GitHub.com uses its own version of the Markdown syntax that provides an additional set of useful features, many of which make it easier to work with content on GitHub.com.

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

