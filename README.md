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