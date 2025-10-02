---
description: "Filter HTTP requests with middleware. Authentication, CORS, logging, and custom filters. Apply globally or per-route."
---

# Middleware

Middleware provides a way to filter or modify HTTP requests before they reach your route handlers. Use middleware for authentication, logging, CORS, rate limiting, and any cross-cutting concerns.

## How Middleware Works

Middleware sits between the request and your application:

1. Request
2. Middleware 1
3. Middleware 2
4. Route Handler
5. Response

Each middleware can:

- Inspect the request
- Modify the request
- Stop the request (return early)
- Modify the response
- Pass the request to the next middleware

## Creating Middleware

To create a Middleware class, create a file in `app/`, such as `app/Middleware/AuthMiddleware.php`, and implement the `MiddlewareInterface`:

```php
<?php

namespace Newtron\App\Middleware;

use Newtron\Core\Http\Request;
use Newtron\Core\Http\Response;
use Newtron\Core\Middleware\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface {
  public function handle(Request $request, callable $next): Response {
    // Do something before the request is handled
      
    // Pass the request to the next middleware
    $response = $next($request);
      
    // Do something after the request is handled
      
    return $response;
  }
}
```

## Basic Middleware

### Before Middleware

Execute code before the route handler:

```php
<?php

namespace Newtron\App\Middleware;

use Newtron\Core\Application\App;
use Newtron\Core\Http\Request;
use Newtron\Core\Http\Response;
use Newtron\Core\Middleware\MiddlewareInterface;

class LogRequests implements MiddlewareInterface {
  public function handle(Request $request, Closure $next) {
    // Log the request
    App::getLogger()->info("Request: {$request->method()} {$request->path()}");
    
    // Continue to route handler
    return $next($request);
  }
}
```

### After Middleware

Execute code after the route handler:

```php
<?php

namespace Newtron\App\Middleware;

use Newtron\Core\Http\Request;
use Newtron\Core\Http\Response;
use Newtron\Core\Middleware\MiddlewareInterface;

class AddHeaders implements MiddlewareInterface {
  public function handle(Request $request, Closure $next) {
    // Get response from route handler
    $response = $next($request);
        
    // Add headers to response
    $response->setHeader('X-Frame-Options', 'SAMEORIGIN');
    $response->setHeader('X-Content-Type-Options', 'nosniff');
        
    return $response;
  }
}
```

### Terminating Middleware

Stop request processing and return a response:

```php
<?php

namespace Newtron\App\Middleware;

use Newtron\Core\Http\Request;
use Newtron\Core\Http\Response;
use Newtron\Core\Middleware\MiddlewareInterface;

class Authenticate implements MiddlewareInterface {
  public function handle(Request $request, Closure $next) {
    if (!$this->isAuthenticated()) {
      // Stop here, don't call route handler
      return Response::createRedirect('/login');
    }
    
    // User is authenticated, continue
    return $next($request);
  }
    
  private function isAuthenticated() {
    // Check if user is logged in
    return isset($_SESSION['user_id']);
  }
}
```

## Registering Middleware

### Global Middleware

Apply middleware to all routes by registering in your application [Launcher](/getting-started/launcher):

```php
<?php
// app/Launcher.php

use Newtron\Core\Application\App;
use Newtron\App\Middleware\LogRequests;
use Newtron\App\Middleware\AddHeaders;

App::addGlobalMiddleware(LogRequests::class);
App::addGlobalMiddleware(AddHeaders::class);
```

### Route Middleware

For file-based routing, include the middleware in the [Route Options array](/routing/file-based#route-options-array):
```php
use Newtron\App\Middleware\Authenticate;

class MyRoute extends FileRoute {
  ...
}

return [
  new MyRoute(),
  [
    'middleware' => [Authenticate::class],
  ]
];
```

For declarative routing, use the `withMiddleware()` function:
```php
use Newtron\App\Middleware\Authenticate;

Route::get('/dashboard', function () {
  ...
})->withMiddleware(Authenticate::class);
```

### Route Group Middleware

Apply middleware to a group of routes with the declarative router:

```php
use App\Middleware\Authenticate;

Route::group(['middleware' => Authenticate::class], function(AbstractRouter $r) {
  $r->get('/dashboard', function () { ... });
  $r->get('/profile', function () { ... });
  $r->get('/settings', function () { ... });
});
```
