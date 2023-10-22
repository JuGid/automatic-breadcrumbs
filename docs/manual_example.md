# Manual breadcrumbs example
Users may need an extra documentation for the manual part. So, here it is !

Using Breadcrumbs class
-----------------------

To add breadcrumbs, you need to use the `Breadcrumbs` class. This is the only public class that can be injected to your controller.
Let's inject it globally in a simple controller class.

```php
<?php

namespace App\Controller;

use Jugid\AutomaticBreadcrumbs\Breadcrumbs; //<- Important !
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleController extends AbstractController
{
    public function __construct(
        private Breadcrumbs $breadcrumbs
    ) {}

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }
}
```

Using the twig extension
------------------------

Now that we have the controller, let's modify the `index.html.twig` by adding the function used for rendering breadcrumbs.
I'm using the default maker bundle template from `make:controller`.

```twig
{% extends 'base.html.twig' %}

{% block title %}Hello SimpleController!{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    
    {{ jugid_breadcrumbs_render() }}
    
</div>
{% endblock %}
```

That's it ! We will personalize our breadcrumbs later.

Adding breadcrumbs
------------------

Now, we can start using the `Breadcrumbs` class to add breadcrumbs to the collection. First, there are functions you need to know to use `Breadcrumbs` :
* `getCollection` : returns the breadcrumbs collection. You can add breadcrumbs to it.
* `addItem(string $text, string $url)` : add a breadcrumb rendered as $text redirecting to $url
* `addRouteItem(string $text, string $route, array $parameters = [])` : add a breadcrumb rendered as $text redirecting to the $route injecting $parameters (to the route generator).

And more advanced function for personalization : 
* `addItemNamespace(string $namespace, string $text, string $url)` : same as `addItem` but add the breadcrumb in a specific $namespace. Behind the scene, `addItem()` adds the breadcrumbs to the `default` namespace.
* `addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = [])` : same as `addRouteItem()` but add breadcrumb in a specific namespace. Behind the scene, `addRouteItem()` adds the breadcrumbs to the `default` namespace.

The same functions exist with `prepend` instead of `add`

Let's use them :

```php
<?php

namespace App\Controller;

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleController extends AbstractController
{
    public function __construct(
        private Breadcrumbs $breadcrumbs
    ) {}

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $collection = $this->breadcrumbs->getCollection();
        $collection
            ->addItem('Index', '/')
            ->addRouteItem('Account', 'app_account')
        ;

        $collection
            ->addItemNamespace('links', 'Google', 'https://google.com')
            ->addItemNamespace('links', 'Github', 'https://github.com')
        ;

        return $this->render('index.html.twig', []);
    }
}
```

I added breadcrumbs to the collection in the `default` namespace and created a namespace `links`.

Now, we can modify the `index.html.twig` to render `links`. Since I don't want them to present as breadcrumbs, I specify another one.

```twig
{% extends 'base.html.twig' %}

{% block title %}Hello SimpleController!{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    
    {{ jugid_breadcrumbs_render() }}
    
    <h1>My links</h1>

    {{ jugid_breadcrumbs_render('links', {separator: '-'}) }}
</div>
{% endblock %}
```

And we're done !
There are other applications to this bundle and you can create lists, menus, ...