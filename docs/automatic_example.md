# Automatic breadcrumbs example
Here is an example of the use of the automatic part.

The controller
--------------

For this example, I'm using a really simple controller :

```php
<?php

namespace App\Controller;

use Jugid\AutomaticBreadcrumbs\Attribute\Breadcrumb; //<- Important
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleController extends AbstractController
{

    #[Breadcrumb(title:'Index', root:true)]
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }

    #[Breadcrumb(title:'Account', root:false)]
    #[Route('/account', name: 'app_account')]
    public function account(): Response
    {
        //...

        return $this->render('account.html.twig', []);
    }

    #[Breadcrumb(title:'Modify account', root:false)]
    #[Route('/account/modify', name: 'app_modify_account')]
    public function modify_account(): Response
    {
        //...

        return $this->render('modify_account.html.twig', []);
    }
}
```

The templates
-------------

And let's make our templates use the twig extension : 

```twig
{# templates/base.html.twig #}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
        {% block stylesheets %}
        {% endblock %}

        {% block javascripts %}
        {% endblock %}
    </head>
    <body>
        {{ jugid_breadcrumbs_render() }}

        {% block body %}{% endblock %}
    </body>
</html>
```

```twig
{# templates/account.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Account{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    Account
</div>
{% endblock %}
```

```twig
{# templates/modify_account.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Modify account{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
</style>

<div class="example-wrapper">
    Modify Account
</div>
{% endblock %}
```

And that's it ! Since your URLs are logical and the bundle can determine the different paths and the texts to print, your breadcrumbs will be perfect.

If the user is on `app_modify_account`, with the default bundle configuration, he sees `Index / Account / Modify account`. If he goes to `app_account`, he will see `Index / Account`. And if he goes to `app_index`, he will see `Index`.

Including paths
---------------

With the bundle, you can restrict the rendering of paths. Let's continue on our `SimpleController`. We can change the configuration as below :

```yaml
jugid_automatic_breadcrumbs:
    includes:
        - '/account/'
```

Now, refresh your page. You should see `Account / Modify account` if you go to `app_modify_account`.

Nos, modify the configuration to this 
```yaml
jugid_automatic_breadcrumbs:
    includes:
        - '!/account/' #Adding ! is the trick
```

Refresh the page. The root path `/account/` has not been rendered ! That's because the `!` tells the bundle to not include the root path. It is usefull when you have workspaces on your website, or component with there own routes path logic.