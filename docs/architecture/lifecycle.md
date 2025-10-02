---
description: "Understand how Newtron processes requests. From initialization to response, see every stage of the application lifecycle."
---

# Application Lifecycle

Understanding how Newtron processes requests helps you know where and when your code runs. This guide walks through the complete lifecycle of a request, from the moment it arrives to when the response is sent.

## The Lifecycle Overview

Every request flows through these stages:

1. Entry Point
2. Application Initialization
3. Service Provider Registration
4. Launcher Setup
5. Service Provider Boot
6. Routing
7. Middleware Pipeline
8. Route Handler Execution
9. Response Generation
10. Response Sending

Let's explore each stage in detail.

## 1. Entry Point

Everything starts in `public/index.php`:

```php
<?php
// public/index.php

require __DIR__ . '/../vendor/autoload.php';

use Newtron\App\Launcher;
use Newtron\Core\Application\App;

App::create(dirname(__DIR__));

Launcher::setup();

App::run();
```

This is the single entry point for all HTTP requests. Your web server routes all requests to this file.

## 2. Application Bootstrap

The `App::create()` method initializes the framework:

```php
$this->loadEnv($rootPath);

$this->defineConstants($rootPath);

$this->loadConfig();

static::$logger = new Logger(NEWTRON_LOGS);
static::$errorHandler = new ErrorHandler(static::$logger, $this->getConfig()->get('app.debug', false));

static::$container = new Container();
static::$serviceProviderRegistry = new ServiceProviderRegistry(static::$container);
$this->registerServices();
```

**What happens:**

- Load `.env` file
- Set up directory paths (routes, config, etc.)
- Load config files from `config/`
- Setup Newtron's ErrorHandler
- Create the dependency injection container
- Bind core services to the container

## 3. Service Provider Registration

Service providers tell the application how to create services.

**What happens:**

- Each service provider's `register()` method is called
- Services are bound to the container
- No services are actually created yet (lazy loading)
- No dependencies between providers should exist at this stage

**Registered by default:**

- Router
- Document/Asset Managers
- Quark engine

## 4. Launcher Setup

Once the main application is ready, the entry file calls `Launcher::setup()`. This is defined in `app/Launcher.php`, and provides a place for you to perform any setup tasks specific to your application.

```php
public static function setup(): void {
  $am = App::getAssetManager();
  $am->registerStylesheet('global', '/style.css');
  $am->useStylesheet('global');
}
```

## 5. Service Provider Boot

After all services are registered, providers are booted. At this point it is safe for services to use other registered services.

**What happens:**

- Each provider's `boot()` method is called
- Providers can now safely use other services
- Routes are loaded
- Middleware is registered
- Application is fully configured

## 6. Routing

The router matches the incoming request to a route:

```php
public static function run(): void {
  static::$serviceProviderRegistry->boot();

  $request = new Request();
  static::getContainer()->instance(Request::class, $request);

  /** @var AbstractRouter $router */
  $router = static::getContainer()->get(AbstractRouter::class);

  $route = $router->dispatch($request);

  if (!$route) {
    static::getLogger()->debug($request->getPath());
    throw new HttpException(Status::NOT_FOUND, Status::NOT_FOUND->getText());
    return;
  }

  $router->execute($route, $request)->send();
}
```

**What happens:**
- Request object is created from PHP superglobals
- Router checks for a matching route pattern
- Route parameters are extracted
- 404 response if no route matches

## 7. Middleware Pipeline

Request passes through registered middleware.

**What happens:**

- Global middleware runs first
- Route-specific middleware runs next
- Each middleware can:
    - Inspect/modify the request
    - Stop execution and return early
    - Pass to next middleware
    - Modify the response after route handler

**Middleware flow:**

1. Request
2. Global Middleware 1 (before)
3. Global Middleware 2 (before)
4. Route Middleware (before)
5. Route Handler
6. Route Middleware (after)
7. Global Middleware 2 (after)
8. Global Middleware 1 (after)
9. Response

## 8. Route Handler Execution

The matched route's handler is executed:

**What happens:**

- Method dependencies are resolved
- Route parameters are injected
- Method is called
- Return value becomes the response

## 9. Response Generation

The route handler's return value is converted to a Response object:

```php
protected function normalizeResponse(mixed $result): Response {
  if ($result instanceof Response) {
    return $result;
  }

  if (is_array($result)) {
    return Response::createJson($result);
  }

  if (is_string($result) || is_numeric($result)) {
    return Response::create((string) $result);
  }

  if (is_null($result)) {
    return Response::create('', Status::NO_CONTENT);
  }

  if (method_exists($result, '__toString')) {
    return Response::create((string) $result);
  }

  throw new \InvalidArgumentException('Invalid response type returned from route handler');
}
```

**What happens:**

- Strings become HTML responses
- Arrays become JSON responses
- Response objects pass through unchanged

## 10. Response Sending

The Response is sent to the browser:

```php
public function send(): void {
  if (!headers_sent()) {
    http_response_code($this->statusCode);

    foreach ($this->headers as $name => $value) {
      header("{$name}: {$value}");
    }

    foreach ($this->cookies as $cookie) {
      setcookie(
        $cookie['name'],
        $cookie['value'],
        time() + $cookie['expires'],
        $cookie['path'],
        $cookie['domain'],
        $cookie['secure'],
        $cookie['httpOnly']
      );
    }
  }

  echo $this->content;
}
```

**What happens:**

- HTTP status code is sent
- Headers are sent
- Cookies are set
- Response body is output
