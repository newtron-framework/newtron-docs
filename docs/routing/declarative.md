# Declarative Routing

Declarative routing gives you explicit control over how URLs map to your application code. Define routes in PHP files in the `routes/` directory with full control.

## Basic Routing

You can define routes using the `Route` helper:

```php
<?php

use Newtron\Core\Http\Response;
use Newtron\Core\Routing\Route;

Route::get('/', function () {
  return Response::create('This is the homepage');
});
```

You can also use the `post()`, `put()`, `patch()`, and `delete()` functions to define routes for different HTTP methods.

Let's take a look at all of the parts of a route declaration:

- `Route::get()`: We use the `get()` function to define a route that accepts a GET request.
- The first argument: The first argument to `Route`'s HTTP functions is the route pattern.
- The second argument: The second argument is a handler function that gets called when the route is executed. This function should return a `Response`.

## Allow Multiple Methods

If you want to allow multiple methods on the same route handler, use `Route::match()`:

```php
Route::match(['GET', 'POST'], '/form', function () {
  // ...
});
```

To allow any method, you can also use `Route::any()`:

```php
Route::any('/webhook', function () {
  // ...
});
```

## Dynamic Routes

Use curly braces `{param}` to create dynamic segments:

```php
// Will match /users/123, /users/456, etc.
Route::get('/users/{id}', function ($id) {
  // ...
});
```

You can also use a question mark after the parameter name to make it optional:

```php
// Will match /users, /users/123, /users/456, etc.
Route::get('/users/{id?}', function ($id) {
  // ...
});
```

## Accessing Dynamic Parameters

Add arguments to your handler function to retreive the values of your dynamic segments:

```php
Route::get('/users/{id}', function ($id) {
  $id; // Contains the value of the [id] segment
});
```

## Adding Middleware

You can add middleware to a single route with the `withMiddlware()` method:

```php
Route::get('/users/{id}', function ($id) {
  // ...
})->withMiddlware(AuthMiddleware::class);
```

## Route Groups

You can also use route groups to batch create routes that share common attributes:

```php
Route::group(['prefix' => '/admin'], function (AbstractRouter $r) {
  $r->get('/dashboard', function () { ... });
  $r->get('/users', function () { ... });
  $r->get('/settings', function () { ... });
});

// Creates these routes:
// /admin/dashboard
// /admin/users
// /admin/settings
```

Here are the valid route group attributes:

| Attribute Key | Value Type | Description |
| --- | --- | --- |
| `prefix` | String | A prefix to prepend to routes within the group |
| `middleware` | Array | An array of middleware classes to apply to routes in the group. Ex: `AuthMiddleware::class` |
