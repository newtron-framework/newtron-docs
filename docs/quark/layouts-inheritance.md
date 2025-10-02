---
description: "Create reusable layouts with Quark. Template inheritance, slots, and nested layouts for consistent page structure."
---

# Layouts and Inheritance

Quark uses a layout system that lets you create reusable page structures and use them in child templates, helping to eliminate repetitive HTML.

## Creating a Layout

A layout is just a normal template that defines some page structure:

```quark
<header>
  <nav>
    <a href="/">Home</a>
    <a href="/about">About</a>
    <a href="/contact">Contact</a>
  </nav>
</header>

<main>
  {~ outlet ~}
</main>

<footer>
  <p>&copy; 2025 My Site</p>
</footer>
```

The one thing that's different in a layout template is the use of the `{~ outlet ~}` directive. This defines the place to render the contents of child templates that use this layout.

## Using a Layout

Use the `{~ layout ~}` directive to inherit a layout:

```quark
{~ layout 'layouts.app' ~}

<h1>Welcome</h1>
<p>This is the homepage content.</p>
```

The child template's content will fill the outlet in the layout.

> Note that layouts are just templates, so `'layouts.app'` just refers to a template at `templates/layouts/app.quark.html`

## Slots

Sometimes you may want to insert content into multiple places within a layout. For this, you can wrap content with `{~ slot ~}` and `{~ endslot ~}`:

```quark
{~ slot sidebar ~}
<h2>Sidebar</h2>
<p>This is sidebar content</p>
{~ endslot ~}
```

Here we define content for a slot named `sidebar`, which will allow us to reference it with a named outlet.

## Named Outlets

By default the `{~ outlet ~}` directive just catches the output of the child template. When used with a name, it will use the content of the slot with the same name:

```quark
<div>
{~ outlet sidebar ~}
</div>
```

This would render content marked by `{~ slot sidebar ~}` in the child template.

## The Root Layout

Quark recognizes one special layout at `templates/_root.quark.html`. This is the **Root Layout**. You can think of it as the top-most parent layout.

The root is a great place for things like your HTML boilerplate that get used on every page. For example, here's Newtron's default root:

```quark
<!DOCTYPE html>
<html>
  <head>
    {{ document->renderHead() | raw }}
  </head>
  <body>
    {~ outlet ~}

    {{ document->renderBodyScripts() | raw }}
  </body>
</html>
```
