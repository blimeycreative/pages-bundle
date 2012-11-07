Add the bundle to required bundles in composer.json

    "require": {
        //Other required bundles
        "savvy/pages-bundle": "dev-master"
    },

Register the bundle in AppKernal.php

    public function registerBundles()
    {
        $bundles = array(
            // other bundles
            new Savvy\PagesBundle\PagesBundle(),
        );
    // ...

Requires 2 lines adding to parameters.yml:

    parameters:
      # ... other parameters
      site_id:           1 #numeric id field value for site to display from main DB
      media_route:       "/path/to/cms/media_files/directory/"

Add the following lines to routing.yml

    pages:
      resource: "@PagesBundle/Controller/"
      type:     annotation
      prefix:   /