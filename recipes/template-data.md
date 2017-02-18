# Template data

Preacher uses version control and environment settings to provide the template
engine with the following data:

| Attribute               | Template call                                                | Example                                  |
|:------------------------|:-------------------------------------------------------------|:-----------------------------------------|
| Author name             | `{{ source.metaData.author.name }}`                          | Jan-Marten de Boer                       |
| Author email            | `{{ source.metaData.author.email }}`                         | preacher@johmanx.com                     |
| Commit reference        | `{{ source.metaData.version }}`                              | fce8b0a0b1fa5f986282b51eb4824b3983c1e6e8 |
| Short commit reference  | `{{ source.metaData.version.short }}`                        | fce8b0a                                  |
| Date created            | `{{ source.metaData.dateCreated&#124;date("Y-m-d H:i") }}`   | 2017-02-04 13:37                         |
| Date updated            | `{{ source.metaData.dateUpdated&#124;date("Y-m-d H:i") }}`   | 2017-02-05 00:42                         |
| Date published          | `{{ output.metaData.datePublished&#124;date("Y-m-d H:i") }}` | 2017-02-05 00:45                         |
| Date generated          | `{{ output.metaData.dateGenerated&#124;date("Y-m-d H:i") }}` | 2017-02-05 00:47                         |
| Number of revisions     | `{{ source.metaData.numRevisions }}`                         | 2                                        |
| Basename of source      | `{{ source.baseName }}`                                      | index                                    |
| Path to source          | `{{ source.path }}`                                          | index.md                                 |
| Path to output          | `{{ output.path }}`                                          | index.html                               |
| Path to template        | `{{ template.path }}`                                        | default.html.twig                        |
| Generated content       | `{{ content }}`                                              | `<h1>My great adventure</h1><p>Lorum...` |
| Headline                | `{{ headline }}`                                             | My great adventure                       |

![Content](https://imgs.xkcd.com/comics/blogging.png)
