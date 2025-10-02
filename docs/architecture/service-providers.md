---
description: "Organize your app with service providers. Register services, configure features, and structure large applications."
---

# Service Providers

Service providers are the central place to configure your application. They tell Newtron how to create services and boot components. Think of them as the organizational backbone of your application.

## What Service Providers Do

Service providers have two jobs:

1. **Register:** Tell the container how to create services
2. **Boot:** Configure your application after all services are registered

```php
<?php

namespace Newtron\App\Providers;

use Newtron\Core\Container\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  public function register(Container $container) {
    // Bind services to the container
  }
  
  public function boot() {
    // Configure your application
  }
}
```

## Creating a Service Provider

Create a class that extends `ServiceProvider`. For example, `app/Providers/AssetServiceProvider.php`:

```php
<?php

namespace Newtron\App\Providers;

use Newtron\Core\Container\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {
  public function register(Container $container) { ... }
    
  public function boot() { ... }
}
```

## The Register Method

The `register()` method is for binding services to the container, and telling the container how to create your service. 

> Only bind services here, don't use other services as they may not have been registered yet.

### Basic Binding

```php
public function register(Container $container) {
  $container->bind(MailService::class, function(Container $c) {
    return new MailService();
  });
}
```

### Singleton Binding

Create one instance that's reused:

```php
public function register(Container $container) {
  $container->singleton('cache', function(Container $c) {
    return new CacheService();
  });
}
```

### Binding Interfaces

Bind interfaces to concrete implementations:

```php
public function register(Container $container) {
  $this->app->bind(
    PaymentGateway::class,
    StripePaymentGateway::class
  );
}
```

Now when code requests `PaymentGateway`, they get `StripePaymentGateway`.

## The Boot Method

The `boot()` method runs after all services are registered. Now you can safely use other services:

### Registering Assets

```php
public function boot() {
  $am = App::getAssetManager();
    
  $am->registerStylesheet('app', '/css/app.css');
  $am->registerStylesheet('admin', '/css/admin.css');
    
  $am->registerScript('app', '/js/app.js');
  $am->registerScript('admin', '/js/admin.js');
}
```

### Setting Quark Globals

```php
public function boot() {
  $engine = App::getContainer()->get(QuarkEngine::class);

  $engine->addGlobal('appName', config('app.name'));
  $engine->addGlobal('version', '1.0.0');
}
```

## Registering Providers

Register your service provider in `app/Launcher.php`:

```php
public static function setup() {
  App::addServiceProvider(AppServiceProvider::class);
  App::addServiceProvider(AssetServiceProvider::class);
}
```

## Accessing Services

Use services registered by providers:

```php
$mailer = App::getContainer->get(MailServiceProvider::class);
```
