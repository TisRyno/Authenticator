# RM Authenticator
A simple Authentication API with multiple providers.

## Currently supports
* Facebook
* GitHub
* Twitter

## Requirements
* PHP >= 7
* [Symfony](https://symfony.com/) 

## Usage

```php
<?php
...
use RmAuthenticatorBundle\Authenticator\Factory;
...

class Controller extends AbstractController
{
    ...
    
    public function index(Request $request, Factory $factory)
    {
        $client = $factory->create($request->request->get('gateway'));
        
        if ($client->supportsFetchUserData()) {
            $client->fetchUserData($request->request->get('username'));
        }
    }
}
```
