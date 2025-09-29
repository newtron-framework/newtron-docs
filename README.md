<p align="center">
  <a href="https://newtron.app" target="_blank">
    <img src="https://raw.githubusercontent.com/newtron-framework/assets/master/newtron-logo.png" alt="newtron" />
  </a>
</p>

A fresh Newtron application ready for you to build something amazing.

## About Newtron

Newtron is a PHP framework built around one core principle: complex features should require embarrassingly simple code.
It's built to solve real developer pain points by making common, complex tasks trivially simple.

## Current Status

Newtron is currently a work in progress. In it's current state, Newtron can support simple static sites.

### ✅ Phase 1 Complete: Core foundation

- Application container with dependency injection
- Request/Response abstraction
- Two routing modes (declarative or file-based)
- Middleware pipeline
- Quark, a custom templating engine
- Error handling and logging

### 🚧 Up Next: Developer experience improvements and the signature forms system

## Requirements

- PHP 8.3 or higher
- Composer

## Installation

```bash
composer create-project newtron/app my-app
```

## Quick Start

```bash
// Start a development server
cd public && php -S localhost:8000
```

```php
// Create your first page (file-based routing)
// /routes/hello.php
<?php

use Newtron\Core\Http\Response;
use Newtron\Core\Routing\FileRoute;

class Hello extends FileRoute {
  public function get(): void {
    return;
  }

  public function render(mixed $data): mixed {
    return Response::create('Hello world!');
  }
}

// Or add a new route (declarative routing)
// /routes/web.php
<?php

use Newtron\Core\Http\Response;
use Newtron\Core\Routing\Route;

Route::get('/hello', function () {
  return Response::create('Hello world!');
});


// Visit http://localhost:8000/hello
```

## Project Structure

```bash
my-app/
├── app/
│   └── Launcher.php        # Helper for custom initialization
├── config/
│   ├── app.php             # Application configuration
│   └── routing.php         # Routing settings
├── public/
│   ├── favicon.ico
│   ├── index.php           # Application entry point
│   └── styles.css
├── routes/
│   └── welcome.php         # Welcome file-based route
└── templates/
    └── welcome.quark.html  # Quark welcome template
```

## Need Help?

- Documentation: WIP
- [Issues](https://github.com/newtron-framework/newtron/issues)
- [Discussions](https://github.com/newtron-framework/newtron/discussions)

## Stay Updated

Newtron is in active development. Watch the repository to get notified when new phases are released.

The best is yet to come! 🚀
