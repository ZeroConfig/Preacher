# Implementing Schema.org

> Schema.org is a collaborative, community activity with a mission to create, maintain, and promote schemas for structured data on the Internet, on web pages, in email messages, and beyond.

See [schema.org](https://schema.org) for more information.

# Example article

This is an example of what could be done to implement Schema.org for a basic page.

```twig
<main itemscope itemtype="https://schema.org/CreativeWork">
    <aside>
        <span itemprop="datePublished">{{ output.metaData.datePublished|date("Y-m-d H:i") }}</span>
        <a href="/" id="author" itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">{{ source.metaData.author.name }}</span></a>
        <span itemprop="name">{{ headline|default(source.baseName) }}</span>
        <span itemprop="version">Version {{ source.metaData.numRevisions }}</span>
    </aside>
    <article id="content" itemprop="text">
        {{ content }}
    </article>
</main>
```

For more inspiration, see
[the CreativeWork specification](https://schema.org/CreativeWork) and
[available template data](/README.html) in the manual.
