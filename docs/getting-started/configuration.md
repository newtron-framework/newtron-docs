# Configuration

Newtron uses a simple configuration system combining PHP config files and environment files.

## Application Configuration File

The main application config is in `config/app.php`:

```php
<?php

return [
  // Application name
  'name' => 'Newtron',

  // Debug mode
  'debug' => false,
];
```

The default app config options are:

| Config Key | Description | Accepted Values |
| --- | --- | --- |
| `name` | The application name | String |
| `debug` | Enable/disable debug mode | Boolean |

## Routing Configuration File

Routing settings can be managed in `config/routing.php`:

```php
<?php

return [
  // Routing mode
  'mode' => 'file',
];
```

The default routing config options are:

| Config Key | Description | Accepted Values |
| --- | --- | --- |
| `mode` | The routing mode to use | `file`, `declarative` |

## Creating Custom Configuration

Create your own configuration files in `config/` for different parts of your application:

```php
<?php

return [
  'my-feature' => [
    'key' => 'FEATURE_KEY',
    'title' => 'My Feature',
  ],
];
```

Or if you prefer, Newtron will automatically load a `.env` file in your project root:

```env
AWS_KEY=YOUR_AWS_KEY
STRIPE_KEY=YOUR_STRIPE_KEY
DB_CONNECTION=mysql
# ... etc
```

## Accessing Configuration Values

To access configuration values anywhere in your application:

```php
App::getConfig()->get('app.name');

// or with a default/fallback value
App::getConfig()->get('app.name', 'Newtron');
```

You can access any environment variables from your `.env` with PHP's `getenv()` or the `$_ENV` superglobal:

```php
getenv('DB_CONNECTION');

$_ENV('DB_CONNECTION');
```

## Debug Mode

Debug mode controls error display and logging. To enable debug mode, edit your `config/app.php` file:

```php
  'debug' => true,
```

When enabled, debug mode: 

- Provides detailed error pages with stack traces
- Displays all errors in the browser

When disabled:

- Generic error pages are used
- Errors are logged in `logs/`, but not displayed in detail
- Minimal output to avoid information leakage

> Always disable debug mode in production
