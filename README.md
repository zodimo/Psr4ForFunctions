# Psr4 For Functions

Attempt to create and autoloader for namespace functions. Maybe it will become a composer plugin, maybe not.

# Composer docs: Files under autoload

If you want to require certain files explicitly on every request then you can use the files autoloading mechanism. This
is useful if your package includes PHP functions that cannot be autoloaded by PHP.

The Goal of this package is to not have to do this for functions.

```json
{
  "autoload": {
    "files": [
      "src/MyLibrary/functions.php"
    ]
  }
}
```

# Ideas

- first version can lazy load the files
- hook into dumpautoload to create cached files of functions loaded.

# PSR4

- https://www.php-fig.org/psr/psr-4/
-

# Problem / Challenge

PHP throws fatal error when function is not found. No handler can be hooked up to this error to autoload the function.

```text
PHP Fatal error:  Uncaught Error: Call to undefined function
```

# How to use
- create functions in the functions folder
- without namespaces (the trait will remove them anyway)
- filename match function name
- add phpdoc typehints on root class for ide support


# Example under examples
```php
<?php declare(strict_types=1);

namespace MyApp;

use Zodimo\Psr4ForFunctions\FunctionLoaderTrait;

/**
 * @method static int sum(int $a, int $b)
 */
class Math
{
    use FunctionLoaderTrait;
}
 
// usage
$total1 = \MyApp\Math::sum(1, 2);
echo "Total1: $total1\n";
```


# The good
- avoids function name collisions
- separation of code