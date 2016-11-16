# OpenZac API PHP Client

This is the PHP client for the OpenZac API.

## Getting Started

You'll need an API key. Get one at https://openzac.com.

## Creating an instance of the client

```php
$apiToken = 'YOUR_TOKEN';
$client = new TeamZac\OpenZac\OpenZac($apiToken);
```

### In Laravel

Include the service provider in your config/app.php file:

```php
TeamZac\OpenZac\OpenZacServiceProvider::class,
```

Publish the package's config file:

```cl
$ php artisan vendor:publish --provider="TeamZac\OpenZac\OpenZacServiceProvider"
```

Add your API token, preferably to your .env file:

```
OPENZAC_API_TOKEN=YOUR_TOKEN
```

Or set it directly in the config file:

```php
'token' => 'YOUR_TOKEN'
```

The service provider binds a singleton instance of ```TeamZac\OpenZac\OpenZac``` to the IoC container, which you can access using the key 'OpenZac':

```php
app('OpenZac');
```

## Using the client

The remainder of the documentation will assume you're using Laravel. If not, you can replace ```app('OpenZac)``` with a normal instance of ```TeamZac\OpenZac\OpenZac```.

We're fleshing out a fluent interface to the API, but for now you can just use the ```get()``` method on the client, providing a URI path and optionally any parameters or headers you wish to pass along:

```php
app('OpenZac')->get('entities/austin-texas');

app('OpenZac')->get('sales-tax/collections/2016/11', [
    'page' => 2,
    'take' => 25
]);
```

## Retreiving Entities

We do have a minimally developed interface for accessing 'entity' resources. You can access this interface using the ```entities``` attribute on the OpenZac instance:

```php
app('OpenZac')->entities;
```

There are two public methods on this resource: ```all()``` and ```find()```.

### all()

```app('OpenZac')->entities->all()``` is the same as calling ```get('entities')```. You can pass an array of query parameters as the lone argument:

```php
app('OpenZac')->entities->all(['page' => 3]);
```

### find()

The ```find()``` method takes an entity ID as its lone parameter, and will retrieve a single entity record.

```php
app('OpenZac')->entities->find('austin-texas');
```

## Resources and Collections

API calls return either an instance of ```TeamZac\OpenZac\Support\Resource``` or ```TeamZac\OpenZac\Support\ResourceCollection```.

### TeamZac\OpenZac\Support\Resource

Right now this is just a simple wrapper for the response which allows you to access data as properties on the Resource object.

```php
$austin = app('OpenZac')->entities->find('austin-texas');
$austin->name;
// prints 'Austin'
```

The infrastructure is in place to provide more helpful functionality by using this as a base class. Future development plans include each resource having it's own subclass. This will allow for casting attributes to certain data types and potentially other valuable features.

### TeamZac\OpenZac\Support\ResourceCollection

This is a simple wrapper around responses that return more than a single resource. It has a couple of public methods which may be useful:

```data()``` returns the resources, which are subclasses of ```TeamZac\OpenZac\Support\Resource```.

```meta()``` returns any metadata associated with the response. Typically this will just be information related to pagination where applicable.

```nextPage()``` returns the next page number or ```null``` if it does not exist.

```previousPage()``` returns the previous page number or ```null``` if it does not exist.
