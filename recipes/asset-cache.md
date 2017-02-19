# Managing cache for assets

When hosting a static website, one of the hurdles one might have is that assets
are being cached for quite a good period. There is a really good reason for that.

If you want to know more about how browsers and servers handle caching of assets,
there is a really great blog article from Facebook, on how they
[saved 60% of requests to Facebook](https://code.facebook.com/posts/557147474482256).

## Using a cache buster

One can simply create a cache buster. This will make the URL unique for every
commit.

```twig
<link href="https://zeroconfig.github.io/Preacher/css/style.css?{{ source.metaData.version.short }}" rel="stylesheet" type="text/css" />
```

However, this makes every asset flush when a page has been updated, rather than
the contents of the asset.

## Versioned assets

In its framework, Symfony extends Twig by adding an
[asset function](http://symfony.com/doc/current/reference/twig_reference.html#asset)
to Twig.

Preacher uses a custom `asset` function that uses the same approach. It uses the
last commit reference of an asset as version tag for the asset.

```twig
{{ asset('css/style.css') }}
```

Since asset URLs are generated, there is no runtime overhead.

This becomes:

```twig
<link href="https://zeroconfig.github.io/Preacher/{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
```

And outputs:

```html
<link href="https://zeroconfig.github.io/Preacher/css/style.css?3eaf1a0" rel="stylesheet" type="text/css" />
```

## Keep your cache in check

Be sure that you actually serve content. If you update your stylesheet, commit
that separately, push it and then rebuild your HTML files.

If you want to make sure all pages are using the latest assets, try:

```shell
vendor/bin/preach --force
```

![The Cloud](https://imgs.xkcd.com/comics/the_cloud.png)

> There's planned downtime every night when we turn on the Roomba and it runs over the cord.
