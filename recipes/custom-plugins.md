# Creating a Preacher plugin

Preacher supports the use of custom plugins. One might want to swap out a
component for Preacher, or add new behavior.

By adding the following to your plugin package, the package is recognized as a
Preacher plugin:

```json
{
  "type": "preacher-plugin",
  "require": {
    "symfony/symfony": "^3.0",
    "zero-config/preacher-installer": "^1.0"
  },
  "extra": {
    "class": "\\My\\Preacher\\Plugin\\AwesomeBundle"
  }
}
```

The package `"zero-config/preacher-installer"` allows for the installation of
plugins.

Composer uses the type `preacher-plugin` to recognize packages that need to be
installed using the Preacher installer.

In the `extra.class` section, the class name of your
[Symfony bundle](http://symfony.com/doc/current/bundles.html) must be configured.
 
## Override existing behavior
 
If existing behavior needs to be overridden, please add the following to your
bundle:

```php
<?php
namespace My\Preacher\Plugin;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AwesomeBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent(): string
    {
        return 'PreacherBundle';
    }    
}
```
