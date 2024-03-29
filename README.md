# Automatic Breadcrumbs Bundle
[![codecov](https://codecov.io/gh/JuGid/automatic-breadcrumbs/graph/badge.svg?token=64MZ6L6361)](https://codecov.io/gh/JuGid/automatic-breadcrumbs) 

This bundle helps you creating automatic and manual breadcrumbs for your Symfony project.

Compatibility
=============

- php >= 8
- Symfony >= 6

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require jugid/automatic-breadcrumbs-bundle
```
That's it !

Applications that don't use Symfony Flex
----------------------------------------

### Step 1 : Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require jugid/automatic-breadcrumbs-bundle
```

### Step 2 : Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Jugid\AutomaticBreadcrumbs\AutomaticBreadcrumbsBundle::class => ['all' => true],
];
```

### Step 3 : Configure the bundle in `config/packages/jugid_automatic_breadcrumbs.yaml`:
    
``` yaml
# config/packages/jugid_automatic_breadcrumbs.yaml
jugid_automatic_breadcrumbs: ~
```

That's it ! For more detailled options, visit the `/docs` folder on this github repository.

Examples
========
Those examples are the simplest examples we can provide : 

When breadcrumbs are created automatically : 
--------------------------------------------
```php
// src/Controller/MyController.php

use Jugid\AutomaticBreadcrumbs\Attribute\Breadcrumb;

#[Breadcrumb(title:'Index', root:true)]
#[Route('/', name: 'app_test')]
public function index(Breadcrumbs $b): Response
{
    //...
}
```

When breadcrumbs are created manually : 
---------------------------------------
```php
// src/Controller/MyController.php

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;

#[Route('/', name: 'app_index')]
public function index(Breadcrumbs $breadcrumbs): Response
{
    $breadcrumbs
        ->getCollection()
        ->addItem('Github', 'http://github.com')
    ;

    return $this->render('index.html.twig', []);
}
```

Help needed
===========

* [tests] Unit tests ([#1][i1])
* [feature] More views ([#2][i2])
* [feature] PHP7 compatibility ([#3][i3])

Contributing
============
We welcome contributions to this project, including pull requests and issues (and discussions on existing issues).

Originally created for [Suitvie](https://suitvie.fr) (bêta 0.3.0)
Inspired by [mhujer/BreadcrumbsBundle](https://github.com/mhujer/BreadcrumbsBundle)

[i1]: https://github.com/JuGid/automatic-breadcrumbs/issues/1
[i2]: https://github.com/JuGid/automatic-breadcrumbs/issues/2
[i3]: https://github.com/JuGid/automatic-breadcrumbs/issues/3