DdeboerGuzzleBundle
===================

DdeboerGuzzleBundle is a Symfony2 bundle for integrating the [Guzzle PHP library](http://github.com/guzzle/guzzle) in your project.

## Installation

Using composer :

1. Add ``socloz/guzzle-bundle`` as a dependency in your project's ``composer.json`` file:

        {
            "require": {
                "socloz/guzzle-bundle": "dev-socloz-master",
            }
        }

2. Install your dependencies:

        php composer.phar update

### Enable the bundle

Enable the bundle in the kernel

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ddeboer\GuzzleBundle\DdeboerGuzzleBundle(),
    );
}
```

### Configure the bundle

Add a custom service client :

```
<?php

/*
 * Copyright CloseToMe 2011/2012
 */

namespace Acme\ExampleBundle\Webservice;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class MyWebserviceClient extends Client
{

    public static function factory($config = array())
    {
        $client = new self($config['base_url'], $config);
        // Attach a service description to the client
        $description = ServiceDescription::factory($config);
        $client->setDescription($description);

        return $client;
    }
}
```

To define your 
``` yaml
# app/config/config.yml
ddeboer_guzzle:
  service_builder:
    configuration:
      Stats:
        class: "Acme\\ExampleBundle\\Webservice\\MyWebserviceClient"
        params:
          operations:
            OperationName:
              httpMethod: GET
              uri: /search
              parameters:
                query:
                  location: query
                  required: true
                  type: string
                sort:
                  location: query
                  type: string
```

See the [Guzzle documentation](http://guzzlephp.org/tour/using_services.html#instantiating-web-service-clients-using-a-servicebuilder) for more information.

## License

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
