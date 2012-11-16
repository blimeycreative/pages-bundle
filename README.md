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