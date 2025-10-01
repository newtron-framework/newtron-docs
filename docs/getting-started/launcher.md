# Launcher

When using the `newtron/skeleton` starter, Newtron includes a Launcher file at `app/Launcher.php`. This is your application's entry point for setup and the perfect place to register services, configure assets, and prepare your application before it handles requests.

## What is the Launcher?

The Launcher's `setup()` function runs during application initialization, after Newtron's core is ready but before any requests are handled. Think of it as your application's configuration hub.

```php
<?php

namespace Newtron\App;

use Newtron\Core\Application\App;

class Launcher {
  public static function setup(): void {
    // Your application setup goes here
  }
}
```

## When It Runs

The Launcher executes during the application bootstrap process:

1. Newtron core initializes
2. Configuration loads
3. Core services register
4. Routes load
5. Launcher::setup() runs (You are here)
6. Application is ready

At this point, the application is fully initialized and you can safely use any Newtron services.

## Basic Setup

### Registering Assets

The most common use is registering your application's assets:

```php
<?php

namespace Newtron\App;

use Newtron\Core\Application\App;

class Launcher {
  public static function setup(): void {
    $am = App::getDocument()->getAssetManager();
    
    // Register stylesheets
    $am->registerStylesheet('app', '/css/app.css');
    $am->registerStylesheet('admin', '/css/admin.css');
    
    // Register scripts
    $am->registerScript('app', '/js/app.js');
    $am->registerScript('admin', '/js/admin.js');
  }
}
```

Now you can use these assets anywhere in your application.

### Setting Global Document Metadata

Configure default document settings:

```php
public static function setup(): void {
  $doc = App::getDocument();
  
  // Set default favicon
  $doc->setFavicon('/my-favicon.ico');
  
  // Set default language
  $doc->setLang('en');
  
  // Add global meta tags
  $doc->setMeta('viewport', 'width=device-width, initial-scale=1');
  $doc->setMeta('author', 'Your Name');
}
```

### Registering Middleware

Set up application-wide middleware:

```php
use Newtron\App\Middlware\TrimStrings;

public static function setup(): void {
  // Register global middleware
  App::addGlobalMiddleware(TrimStrings::class);
}
```

## Accessing the Application

The `App` class provides access to all Newtron services:

```php
// Get services
$document       = App::getDocument();
$assetManager   = App::getAssetManager();
$request        = App::getRequest();
$config         = App::getConfig();
$logger         = App::getLogger();

// Resolve from container
$service = App::getContainer()->get('service-name');
```

## Best Practices

### Keep It Organized

Break setup into focused methods:

```php
public static function setup(): void {
  self::registerAssets();
  self::configureDocument();
  self::registerMiddleware();
  self::initializeServices();
}
```

### Don't Do Heavy Work

The Launcher runs on every request—keep it fast:

```php
// Good - lightweight registration
$am->registerStylesheet('app', '/css/app.css');

// Bad - expensive operations
$files = glob(base_path('css/*.css'));
foreach ($files as $file) {
  $am->registerStylesheet(basename($file), $file);
}
```

## Launcher vs Service Providers

The Launcher is simpler than Service Providers:

**Use Launcher for:**
- Quick application setup
- Registering assets
- Configuring middleware
- Simple, straightforward configuration

**Use Service Providers for:**
- Complex dependency injection
- Organizing large applications
- Reusable packages
- Deferred loading of services

For most applications, the Launcher is all you need. As your app grows, you can migrate to Service Providers for better organization.
