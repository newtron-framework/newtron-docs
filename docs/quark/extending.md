---
description: "Extend Quark with custom filters and directives. Add your own template features to match your application's needs."
---

# Extending Quark

Quark is designed to be easily extended for any custom functionality you may need.

## Accessing the Quark Engine and Compiler

To get the application's instance of the Quark Engine, request it with the app's service container:

```php
use Newtron\Core\Application\App;
use Newtron\Core\Quark\QuarkEngine;

$engine = App::getContainer->get(QuarkEngine::class);
```

You can then get the Compiler from the engine:

```php
$compiler = $engine->getCompiler();
```

## Adding Globals

Quark allows you to define your own global values to be accessible in all templates:

```php
// In a service provider or app/Launcher.php

$engine = App::getContainer->get(QuarkEngine::class);

$value = 'some_value';

$engine->addGlobal('myGlobal', $value);
```

This allows you to use the global variable in your templates:

```quark
<p>{{ myGlobal }}</p>
```

```html
<p>some_value</p>
```

## Adding Custom Filters

Quark allows you to register your own filters to be used in [piping an expression](/quark/filters). 

A filter is a function that takes in the value, and outputs the changed value.

As an example, let's add a filter to wrap a value in quotes:

```php
$engine = App::getContainer->get(QuarkEngine::class);

$engine->addFilter('quote', fn($v) => '"' . $v . '"');
```

This filter can then be used in templates:

```quark
// With $value = 'That's cool!';
<p>{{ value | quote }}</p>
```

```html
<p>"That's cool!"</p>
```

## Adding Custom Directives

Quark allows for you to define custom directives for use in templates. 

A directive uses a function to output PHP code when a template is compiled.

As an example, let's add a directive to set the page title:

```php
$engine = App::getContainer->get(QuarkEngine::class);
$compiler = $engine->getCompiler();

$compiler->addDirective('title', function ($args) {
  $title = trim($args, '"\'');
  return "\$document->setTitle('{$title}');\n"
});
```

This directive can then be used in templates to set the page title:

```quark
{~ title 'My Page' ~}
```

Which would generate in the page's `<title>` tag:

```html
<title>My Page</title>
```

## Global Values in Directives

When writing the resulting PHP for a directive, there are a few global values that you can access:

| Variable | Description |
| --- | --- |
| `$__quark` | The Quark Engine instane |
| `$document` | A reference to the [Document](/document/document-management) instance |
| `$request` | The [Request](/http/handling-requests) object for the current request |
