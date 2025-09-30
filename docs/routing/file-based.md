# File-Based Routing

The file-based routing mode is Newtron's convention-over-configuration approach to routing. Create a file, get a route.

## How It Works

Every PHP file in the `routes/` directory is automatically loaded as a route.

```bash
routes/
├── _index.php          → /
├── about.php           → /about
├── contact.php         → /contact
└── blog/
    ├── _index.php      → /blog
    └── archive.php     → /blog/archive
```

## Creating Your First Route

Create `routes/hello.php`:

```php
<?php

use Newtron\Core\Routing\FileRoute;

class Hello extends FileRoute {
  public function get(): void {
    return;
  }

  public function render(mixed $data): mixed {
    return 'Hello!';
  }
}

return [new Hello()];
```

Let's go over a few important things to note about file routes:

- Every file-based route uses a class that extends `FileRoute`.
- Every file-based route must implement the `render()` method. This is the method the router calls to get the response to send back to the browser.
- Every file-based route must return a Route Options array, with the first argument being an instance of your route class. This passes all the settings for your route to the router so it can be registered properly.
- To allow an HTTP method on your route, create a method with a matching name. In our example, we defined a `get()` method, so our route will accept GET requests. [Learn more about Preflight Functions](#preflight-functions)

## Index Files

The file-based router recognizes `_index` as a special file name. Files named `_index.php` represent the directory itself:

```bash
routes/
├── _index.php          → /
└── blog/
    └── _index.php      → /blog
```

This is similar to how `index.html` works in traditional web servers.

## Nested Routes

Create nested URLs using the folder structure:

```bash
routes/
└── docs/
    ├── _index.php          → /docs
    ├── getting-started.php → /docs/getting-started
    └── api/
        ├── _index.php      → /docs/api
        └── reference.php   → /docs/api/reference
```

You can also created a nested URL by using dots (`.`) in the filename:

```bash
routes/
├── docs.php                    → /docs
├── docs.getting-started.php    → /docs
├── docs.api.php                → /docs/api
└── docs.api.reference.php      → /docs/api/reference
```

## Dynamic Routes

Use square brackets `[param]` in a file name to create dynamic segments:

```bash
routes/
└── users/
    └── [id].php            → /users/123, /users/456, etc.
```

You can also use a question mark after the parameter name to make it optional:

```bash
routes/
└── users/
    └── [id?].php            → /users, /users/123, /users/456, etc.
```

## Accessing Dynamic Parameters

In your [Preflight Functions](#preflight-functions), add arguments matching your dynamic segments to retreive their values:

```php
// routes/users/[id].php

public function get(string $id) {
  $userId = $id; // $id will automatically contain the value of the 'id' URL segment
}
```

## Preflight Functions

In order to allow an HTTP method on your file-based route, you create what we call a **Preflight Function**. This is just a method with the same name as an HTTP method, such as `get()` for a GET request or `post()` for a POST request.

When a request comes in, the matching Preflight Function is executed *before* your route's `render()` method. This makes it really handy to perform any setup you need before rendering, like fetching some data based on a dynamic route segment.

You may have noticed when we define a route's `render()` method, it includes a `$data` argument. This argument is used to pass any data from your Preflight Functions to your `render()` method. For example, if we have the following `get()` preflight:

```php
public function get() {
  return ['coolValue' => 'Newtron is cool'];
}
```

Then when a get request comes in and our `get()` preflight is called, our `render()` method will receive the `['coolValue' => 'Newtron is cool']` array as its `$data` argument, so we can use it in for rendering.

In order to retreive the value of dynamic route segments, you just add those segments as arguments to your Preflight Functions:

```php
// routes/blog.[year].[month].[slug].php

public function get(string $year, string $month, string $slug) {
  $year;    // Contains the value of the [year] segment
  $month;   // Contains the value of the [month] segment
  $slug;    // Contains the value of the [slug] segment
}
```

## Route Options Array

At the end of your file-based routes, you return a Route Options array. The router uses this array to properly register the route with any additional configuration we need.

The first argument is always an instance of your route class, like `new Hello()`.

The second argument is an optional array of configuration options for the route. The accepted values are:

| Option Key | Value Type | Description |
| --- | --- | --- |
| `middleware` | Array | An array of middleware classes to execute on the route. Ex: `AuthMiddleware::class` |
