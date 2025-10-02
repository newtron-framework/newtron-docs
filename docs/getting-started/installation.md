---
description: "Install Newtron with Composer and create your first project. Supports PHP 8.3+ on any hosting platform."
---

# Installation

Get up and running in just a few minutes.

## Requirements

Before installing Newtron, make sure your system meets these requirements:

- PHP 8.3+
- Composer

## Creating a New Project

The easiest way to create a new Newtron application is using Composer's `create-project` command:

```bash
composer create-project newtron/app my-app
```

This will:

1. Download the Newtron starter project
2. Install the dependencies (newtron/core)
3. Set up the basic project structure

Once the installation completes, navigate to your new project:

```bash
cd my-app
```

And start it up:

```bash
cd public && php -S localhost:8000
```

You should now be able to see the Newtron welcome page by navigating to `http://localhost:8000`!

## Project Structure

After installation, your project will have this structure:

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
│   └── style.css
├── routes/
│   └── _index.php          # Welcome file-based route
├── templates/
│   ├── _root.quark.html    # Root layout
│   └── welcome.quark.html  # Welcome template
└── composer.json
```

## Next Steps

Now that Newtron is installed, you're ready to start building:

- [Your First Application](/getting-started/first-app) - Build a simple hello world app
- [Routing](/routing/introduction) - Learn about Newtron's two routing modes
- [Quark Templates](/quark/template-basics) - Learn about Newtron's templating engine, Quark
