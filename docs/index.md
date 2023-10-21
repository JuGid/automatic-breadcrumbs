# Jugid Automatic Bundle Documentation
This bundle helps you creating automatic and non-automatic breadcrumbs for your Symfony project
This file is its documentation.

## Usage
This bundle helps you to create breadcrumbs for your user in two ways : Automatic and Manual.

### Automatic
If you set your `automatic` option to true or still have the default value (that is `true`), there is no more example as your breadcrumbs will be generated thanks to the bundle.

You just have to add the PHP attribute Breadcrumb added by this bundle

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

### Manual
This is a simple example already written in the README : 

```php
// src/Controller/MyController.php

use Jugid\AutomaticBreadcrumbs\Breadcrumbs;

#[Route('/', name: 'app_index')]
public function index(Breadcrumbs $breadcrumbs): Response
{
    $breadcrumbs
        ->getCollection()
        ->addItem('Google', 'http://google.fr')
    ;

    return $this->render('index.html.twig', []);
}
```
### Warning using both
This isn't the typical way this bundle operates, but you have the flexibility to do as you wish. Just be aware that the subscriber used for automatic breadcrumbs is registered on the `kernel.controller` event. Therefore, the automatic breadcrumbs are already added when you inject the Breadcrumbs class and use it in your controller.

### Render the breadcrumbs
This bundle adds a twig extension that let you use the `jugid_breadcrumbs_render` function.
In your template just add `{{ jugid_breadcrumbs_render() }}`.

#### Function options
To this function, you can pass multiple parameters in.
```yaml
separator:string = breadcrumbs separator
template:string = path to the template
```

```jinja
{{ jugid_breadcrumbs_render('default', {separator: '-', template: 'my_template.html.twig'}) }}
```

### Breadcrumbs attribute
For automatic breadcrumbs, the bundle needs to know the text to print. This is done thanks to the Breadcrumb attribute.
```php
#[Breadcrumb(title:'Index')]
```

There is another parameter named root that can be use : `root`. If this parameter is set to `true`, the bundle will not add any parent breadcrumbs. For example, if your application's routes are logically `/account/offers/premium/`. The bundle will tests the routes `['/account/offers/premium/', '/account/offers/', '/account/', '/']` but `/account/` breadcrumb attribute has the parameter `root` to `true`, then the `/` breadcrumb will not be rendered.

By default, this parameter is set to `false`.

## Configuration

### Default configuration
This bundle comes with a default configuration :
```yaml
jugid_automatic_breadcrumbs:
    automatic: true
    detect_mode: false
    separator: '/'
    template: @AutomaticBreadcrumbs/view.html.twig
    collection_class: Jugid\AutomaticBreadcrumbs\Collection\BreadcrumbsCollection
    strategy_class: 'Jugid\AutomaticBreadcrumbs\Strategy\HierarchyStrategy'
    includes:
```
### Change it !
You can override any elements to your needs by adding a `jugid_automatic_breadcrumbs.yaml` file in your `config/packages` directory.

### Warning : includes
The includes parameter is a bit special. By setting it, you can choose to include path. By default, this parameter is empty and all paths are included.
For example, suppose you have route paths like : `/account/member`, `/special/offers/premium`, `/account/configuration/modify` and have includes as below.

```yaml
jugid_automatic_breadcrumbs:
    includes:
        - '/account/'
```

The path including `/account/` at the begining will be rendered (`/account/member`, `/account/configuration/modify`), including the root `/account/`. Add a ! to not print the root route path `/account/` as below.

```yaml
jugid_automatic_breadcrumbs:
    includes:
        - '!/account/'
```

### Views
This bundle provides multiple basic views you can configure.
* `@AutomaticBreadcrumbs/view.html.twig` (by default)
* `@AutomaticBreadcrumbs/tailwind_view.html.twig`

Also, you can override them thanks to Symfony in your project `/templates/bundle/AutomaticBreadcrumbs` folder.
[See the documentation](https://symfony.com/doc/current/bundles/override.html)

### Detect mode
If `detect_mode`is set to true, the bundle will throw an error if the Breadcrumb attribute cannot be resolve.

## Personnalize parts

### Strategy
The strategy is the way the bundle will determine how it can automatically define the breadcrumbs.
The default strategy uses the requested path and decompose it : if the path is /account/profile/ the strategy returns an array with `['/account/profile/', '/account/', '/']`. Then, the bundle tests those paths, get the route (if it exists, otherwise it is ignored), then the controller and detects if there is a Breadcrumb attribute attached to the action function to know which text to print for the path.

You can create your strategy, tag it with `jugid.automati_breadcrumbs.strategy` in your `services.yaml` and set it in the configuration.

You can also pull request your own strategy to contribute !

### Template
You can create your own template and set it in the configuration. The Renderer injects some variables into it :
- `{{ breadcrumb_collection }}` : this is an array of breadcrumbs object implementing the Jugid\AutomaticBreadcrumbs\Model\BreadcrumbsInterface
- `{{ separator }}` : the breadcrumbs separator

### Collection
You can also create your own method storing breadcrumbs. Simply create a class implementing the Jugid\AutomaticBreadcrumbs\Collection\CollectionInterface, tag it as `jugid.automati_breadcrumbs.collection` in your `services.yaml` and set it in the bundle configuration.
The default collection works as the bundle is supposed to work. The default collection implements this methods : 

```php
public function addBreadcrumb(BreadcrumbInterface $breadcrumb, string $namespace = 'default'): self;
public function addItem(string $text, string $url) : self;
public function addRouteItem(string $text, string $route, array $parameters = []): self;
public function addItemNamespace(string $namespace, string $text, string $url) : self;
public function addRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
public function prependItem(string $text, string $url) : self;
public function prependRouteItem(string $text, string $route, array $parameters = []): self;
public function prependItemNamespace(string $namespace, string $text, string $url) : self;
public function prependRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
public function add(string $namespace) : void;
public function clear(string $namespace = 'default') : bool;
public function removeItem(string $text, string $namespace = 'default') : bool;
public function hasItem(string $text, string $namespace = 'default') : bool;
public function hasNamespace(string $namespace = 'default') : bool;
public function extract(string $namespace = 'default') : array;
public function setIncludes(array $includes) : void;
public function isIncluded(string $route) : bool;
public function isEmpty(string $namespace = 'default') : bool;
```