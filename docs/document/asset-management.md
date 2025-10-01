# Asset Management

Newtron's Asset Manager provides a clean way to organize and manage CSS and JavaScript files. Register assets once, then easily include them on any page.

## The Asset Manager

The Asset Manager is part of the Document interface and handles all your CSS and JavaScript files:

```php
use Newtron\Core\Application\App;

$assetManager = App::getAssetManager();
```

## How It Works

Asset management is a two-step process:

1. **Register:** Define your assets with friendly names
2. **Use:** Mark which assets should be included on a page

This separation gives you control over what loads where, without repeating file paths throughout your application.

## Registering Assets

Register a CSS file with a memorable name:

```php
$am = App::getAssetManager();

$am->registerStylesheet('dashboard', '/css/dashboard.css');
$am->registerStylesheet('blog', '/css/blog.css');
$am->registerStylesheet('admin', '/css/admin.css');
```

Now you can reference these stylesheets by name instead of path.

Register JavaScript files the same way:

```php
$am = App::getAssetManager();

$am->registerScript('dashboard', '/js/dashboard.js');
$am->registerScript('blog', '/js/blog.js');
$am->registerScript('admin', '/js/admin.js');
```

Note that stylesheet names and script names are independent, so you can use the same name for both:

```php
$am = App::getAssetManager();

// Both use the name 'dashboard'
$am->registerStylesheet('dashboard', '/css/dashboard.css');
$am->registerScript('dashboard', '/js/dashboard.js');
```

This makes it easy to manage related CSS and JavaScript together.

## Using Assets

Once registered, mark assets as used to include them in the page:

```php
$am = App::getAssetManager();

$am->useStylesheet('dashboard');
$am->useScript('dashboard');
```

The registered files are now included when the page renders.

## Complete Example

Here's a typical workflow:

```php
<?php
// In a service provider or app/Launcher.php

$am = App::getAssetManager();

// Register common assets
$am->registerStylesheet('app', '/css/app.css');
$am->registerStylesheet('blog', '/css/blog.css');
$am->registerStylesheet('admin', '/css/admin.css');

$am->registerScript('app', '/js/app.js');
$am->registerScript('blog', '/js/blog.js');
$am->registerScript('admin', '/js/admin.js');
```

Then in your routes:

```php
<?php
// routes/blog/[slug].php

public function render(mixed $data): mixed {
  $am = App::getAssetManager();

  // Include blog-specific assets
  $am->useStylesheet('app');
  $am->useStylesheet('blog');
  $am->useScript('app');
  $am->useScript('blog');
  
  return Response::create(
    Quark::render('blog.post', $data)
  );
}
```

## Global vs Page-Specific Assets

The Asset Manager shines when you need to manage different asset combinations across pages.

Register assets during application initialization, and use any global assets so they'll be included in every page:

```php
<?php
// In a service provider or app/Launcher.php

$am = App::getAssetManager();

// Register all your application assets
$am->registerStylesheet('app', '/css/app.css');
$am->registerStylesheet('blog', '/css/blog.css');
$am->registerStylesheet('admin', '/css/admin.css');
$am->registerStylesheet('print', '/css/print.css');

$am->registerScript('app', '/js/app.js');
$am->registerScript('blog', '/js/blog.js');
$am->registerScript('admin', '/js/admin.js');
$am->registerScript('analytics', '/js/analytics.js');

$am->useStylesheet('app');
$am->useScript('app');
```

Then in your routes, simply use whatever else you need:

```php
<?php
// routes/_index.php
$am = App::getAssetManager();
$am->useScript('analytics');
```

```php
<?php
// routes/blog/[slug].php
$am = App::getAssetManager();
$am->useStylesheet('blog');
$am->useScript('blog');
$am->useScript('analytics');
```

```php
<?php
// routes/admin/dashboard.php
$am = App::getAssetManager();
$am->useStylesheet('admin');
$am->useScript('admin');
```

## External Assets

The Asset Manager works with external files too:

```php
$am = App::getAssetManager();

// Register CDN assets
$am->registerStylesheet('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
$am->registerScript('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js');

// Use them like any other asset
$am->useStylesheet('bootstrap');
$am->useScript('jquery');
```

## Asset Manager Benefits

### Centralized Asset Definitions

Register all assets in one place during bootstrap. No more hunting for hardcoded paths across your application.

### Easy Refactoring

Need to change a CSS file path? Update it once in the registration, not in every file that uses it:

```php
// Change this once
$am->registerStylesheet('blog', '/css/new-blog.css');

// Instead of updating dozens of files
```

### Conditional Loading

Easily include assets based on conditions:

```php
$am = App::getAssetManager();

$am->useStylesheet('app');

if ($user->isAdmin()) {
  $am->useStylesheet('admin');
  $am->useScript('admin');
}

if ($page->hasComments()) {
  $am->useScript('comments');
}
```

### Prevent Duplicates

The Asset Manager automatically prevents the same asset from being included multiple times, even if different parts of your code try to use it.

## Combined with Direct Asset Loading

The Asset Manager complements the Document's direct asset methods:

```php
$am = App::getAssetManager();

// Use registered asset
$am->useStylesheet('app');

// Also add a one-off stylesheet
$doc->addStylesheet('/css/special-page.css');

// Both will be included
```

This gives you flexibility to use the Asset Manager for organized, reusable assets, and direct methods for one-off includes.
