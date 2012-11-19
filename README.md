Add the bundle to required bundles in composer.json

``` js
"require": {
    //...
    "savvy/pages-bundle": "dev-master"
},
```

Register the bundle in AppKernal.php, you will need to register the KnpLabs Menu Bundle too
if you have not already:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new Savvy\PagesBundle\PagesBundle(),
    );
// ...
```

Requires 2 lines adding to parameters.yml:

``` yaml
parameters:
  # ... other parameters
  site_id:           1 #numeric id field value for site to display from main DB
  media_route:       "/path/to/cms/media_files/directory/"
  media_cache_route: "/path/to/desired/cache/webroot/"
  nav_one_depth:     1 #depth of navigation one links, e.g. depth 2 = top level nav plus one level of sub nav
  nav_two_depth:     2 #depth of navigation two links
```

Add the following lines to routing.yml

``` yaml
pages:
  resource: "@PagesBundle/Controller/"
  type:     annotation
  prefix:   /
```

A default app/Resources/base.html.twig may look like:
``` twig
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>
            {% block title %}
                {% if page is defined %}
                    {{page.title}}
                {% else %}
                    Welcome
                {% endif %}
            {% endblock %}
        </title>
        {% block stylesheets %}{% endblock %}
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <div id="header_wrapper">
            <header id="main_header" class="col12">
            </header>
        </div>
        <div id="navigation_wrapper">
            <nav id="navigation_one">
                {% block navigation_one %}
                    {{ knp_menu_render('PagesBundle:Builder:mainMenu') }}
                {% endblock %}
            </nav>
        </div>
        <div id="content_wrapper">
            {% block navigation_two %}
                <nav id="navigation_two">
                    {% block navigation_two_content %}{% endblock %}
                </nav>
            {% endblock %}
            {% block body %}{% endblock %}
        </div>
        {% block javascripts %}{% endblock %}
    </body>
</html>

```