# Collection function to manipulate breadcrumbs

`Jugid\AutomaticBreadcrumbs\Collection\BreadcrumbsCollection` :
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

`Jugid\AutomaticBreadcrumbs\Collection\DisableBreadcrumbsCollection` adds more : 
```php
public function addDisableItem(string $text, string $url) : self;
public function addDisableRouteItem(string $text, string $route, array $parameters = []): self;
public function addDisableItemNamespace(string $namespace, string $text, string $url) : self;
public function addDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
public function prependDisableItem(string $text, string $url) : self;
public function prependDisableRouteItem(string $text, string $route, array $parameters = []): self;
public function prependDisableItemNamespace(string $namespace, string $text, string $url) : self;
public function prependDisableRouteItemNamespace(string $namespace, string $text, string $route, array $parameters = []): self;
```