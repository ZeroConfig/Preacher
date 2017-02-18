# Creating a draft

Because Preacher leverages existing software and practices, there are multiple
ways of creating a drafted article, without using custom Preacher logic.

> Make each program do one thing well. By focusing on a single task, a program can eliminate much extraneous code that often results in excess overhead, unnecessary complexity, and a lack of flexibility.

As such, Preacher has no own implementation to facilitate drafts.
However, because it elevates GIT, the user is still able to use drafts with one
of the following recipes.

## Use a draft folder

One can choose to put all drafts in `/draft` and then add the following to your
GIT ignore file:

```
/draft/*.html
```

This will ensure everything that is generated inside `/draft/` will not be
stored in version control.

A side effect is that all drafts will be generated each time Preacher is run.
This is because the published date is based on the date at which the output was
first added to version control. Since that never happens, it is always right now
and thus the generator wants to generate its output.

## Extension .draft.md

If you safe your draft files as `file.draft.md` instead of `file.md` and add the
following to your GIT ignore:

```
*.draft.html
```

Then the same rules apply as with the previous recipe, only then without using a
dedicated folder for drafts.

The pro is that your file hierarchy can be determined up-front.

If you want to list all files that are currently in draft, try:

```
find -name *.draft.md
```

This will give you a list of all files that are still in draft. As opposed to
the separate `draft` folder, you need this in order to keep you from forgetting
which articles are still in draft.

## Don't commit

The simplest recipe is also the easiest one to get wrong.
Simply don't commit the output files you don't want published.
The downside to this is that you can easily mistype a command and add it still,
by accident.

## Add sense to your draft commits

![Git Commit](https://imgs.xkcd.com/comics/git_commit.png)

It's easy to skip on a good commit message. If you are writing a draft, it may
be really useful to look at its history if you get back to it after a while.
