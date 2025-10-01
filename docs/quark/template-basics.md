# Quark Template Basics

Quark is Newtron's built-in templating engine. It provides a simple syntax for building templates while remaining just PHP under the hood.

## Creating Templates

Templates are stored in the `templates/` directory and use the `quark.html` extension:

```bash
templates/
├── home.quark.html
├── about.quark.html
└── users/
    ├── index.quark.html
    └── show.quark.html
```

## Rendering Templates

Use the `Quark` helper to render templates:

```php
<?php

use Newtron\Core\Quark\Quark;

Quark::render('home');

// With data
Quark::render('users.show', ['user' => $user]);
```

> Note that nested template names use dot notation

## Displaying Data

Use double curly braces to output an expression or variable:

```quark
<h1>Hello, {{ name }}</h1>
<p>You are {{ age }} years old.</p>
```

## Pipe Filters

When outputting an expression, you can also pass the value through one or more [Filters](/quark/filters):

```quark
<h1>Hello, {{ name | upper }}</h1>
```

## Control Structures

You can perform more complex logic in your templates using [Directives](/quark/directives). Directives use curly braces with percent signs:

```quark
{~ if $user ~}
<p>Welcome, {{ user.name }}!</p>
{~ else ~}
<p>Welcome, guest!</p>
{~ endif ~}

<ul>
  {~ foreach $users as $user ~}
    <li>{{ user.name }}</li>
  {~ endforeach ~}
</ul>
```

## Template Variables

All data passed to `Quark::render()` is available in the template as variables:

```php
Quark::render('page', [
  'title' => 'My Page',
  'content' => 'Page content',
  'items' => [1, 2, 3]
]);
```

```quark
<h1>{{ title }}</h1>
<div>{{ content }}</div>

{~ foreach $items as $item ~}
<p>{{ item }}</p>
{~ endforeach ~}
```
