# Asset Management

Newtron's Document interface includes the Asset Manager to help efficiently manage CSS and JavaScript assets.

## Registering an Asset

To register an asset in the asset manager:

```php
<?php

use Newtron\Core\Application\App;

$am = App::getDocument()->getAssetManager();
$am->registerStylesheet('dashboard', '/styles/dashboard.css');
$am->registerScript('dashboard', '/scripts/dashboard.js');
```

This registers the `dashboard.css` and `dashboard.js` files under the name `dashboard`, so we can easily reference them later. Note that the collection of names for stylesheets and scripts are separate.

## Using an Asset

In order to include a registered asset in the page, we have to mark it as used:

```php
$am = App::getDocument()->getAssetManager();
$am->useStylesheet('dashboard');
$am->useScript('dashboard');
```

Now the stylesheet and script registered with the names `dashboard` will be included in the page. When done early in the [application lifecycle](/architecture/lifecycle), this makes for an easy way to set up global assets.
