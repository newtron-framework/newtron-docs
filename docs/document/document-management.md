---
description: "Set page titles, meta tags, and Open Graph properties with Newtron's Document interface. SEO and social sharing made easy."
---

# Document Management

Newtron's Document interface gives you clean, straightforward control over page metadata and assets. Set titles, manage meta tags, and add CSS/JavaScript with a simple API.

## Accessing the Document

Get the Document instance anywhere in your application:

```php
use Newtron\Core\Application\App;

$document = App::getDocument();
```

## Setting Page Metadata

The Document provides methods for setting the document title, description, language, and favicon.

This sets the `<title>` tag in your document:

```php
App::getDocument()->setTitle('My Page');
```

To set the description:

```php
App::getDocument()->setDescription('A modern PHP framework for building web applications');
```

In the document, this generates:

```html
<meta name="description" content="A modern PHP framework for building web applications">
```

Setting the document language is also simple:

```php
App::getDocument()->setLang('en');
```

This sets the `lang` attribute on the `<html>` tag:

```html
<html lang="en">
```

And a shortcut for setting the favicon:

```php
App::getDocument()->setFavicon('/custom-icon.ico');
```

Which generates this `<link>` tag:

```html
<link href="/custom-icon.ico" rel="icon" type="image/x-icon">
```

## Meta Tags

You can also set custom `<meta>` tags:

```php
App::getDocument()->setMeta('keywords', 'PHP, Framework, Newtron');
```

Which generates:

```html
<meta name="keywords" content="PHP, Framework, Newtron">
```

## Meta Tags with Custom Attributes

Set a `<meta>` tag using a different attribute than `name`:

```php
App::getDocument()->setMeta('refresh', '30', 'http-equiv');
```

```html
<meta http-equiv="refresh" content="30">
```

## Open Graph Tags

Open Graph tags control how your pages appear when shared on social media. Newtron provides a specific helper function to set Open Graph properties:

```php
App::getDocument()->setOG('title', 'My Awesome Page');
App::getDocument()->setOG('description', 'Check out this amazing content');
App::getDocument()->setOG('image', '/images/og-image.jpg');
App::getDocument()->setOG('url', 'https://mysite.com/page');
App::getDocument()->setOG('type', 'website');
```

This then adds the following to the document:

```html
<meta property="og:title" content="My Awesome Page">
<meta property="og:description" content="Check out this amazing content">
<meta property="og:image" content="/images/og-image.jpg">
<meta property="og:url" content="https://mysite.com/page">
<meta property="og:type" content="website">
```

## Adding Links

Add a `<link>` tag to the document head:

```php
App::getDocument()->addLink('/styles.css', 'stylesheet');
```

## Add a Link with Attributes

Pass additional attributes as the third parameter to `addLink()`:

```php
App::getDocument()->addLink('/favicon-32x32.png', 'icon', [
  'type' => 'image/png',
  'sizes' => '32x32',
]);
```

This adds the array items as attributes on the generated `<link>` tag:

```html
<link href="/favicon-32x32.png" rel="icon" type="image/png" sizes="32x32">
```

## Adding CSS

Add a CSS stylesheet to the document:

```php
App::getDocument()->addStylesheet('/custom.css');
```

## Inline Styles

Add CSS directly to the document:

```php
App::getDocument()->addInlineStyle("
  .box {
    border: 1px solid red;
  }
");
```

Which gets rendered in a `<style>` tag:

```html
<style>
  .box {
    border: 1px solid red;
  }
</style>
```

## Adding JavaScript

Add a script to the document:

```php
App::getDocument()->addScript('custom.js');
```

To set attributes on the `<script>` tag, pass an array to `addScript()`:

```php
App::getDocument()->addScript('custom.js', ['defer' => 'defer']);
```

You can also add an inline script directly in a `<script>` tag:

```php
App::getDocument()->addInlineScript('console.log("Hello from Newtron");', ['defer' => 'defer']);
```

## Scripts in Body

By default, scripts are added to the document `<head>`. Pass `true` as the third parameter when adding a script to add it to the end of `<body>` instead:

```php
App::getDocument()->addScript('custom.js', ['defer' => 'defer'], true);

App::getDocument()->addInlineScript(
  'console.log("Hello from Newtron");',
  ['defer' => 'defer'],
  true
);
```

## Method Chaining

All Document methods support chaining for cleaner code:

```php
App::getDocument()
  ->setTitle('My Page')
  ->setDescription('Page description')
  ->setOG('image', '/image.jpg')
  ->addStylesheet('/css/app.css')
  ->addScript('/js/app.js', ['defer' => 'defer'], true);
```

## Usage in Quark Templates

Newtron automatically provides the Document as a global variable in Quark templates:

```quark
{{ document.getTitle() }}
```

## Rendering Document Elements

In your layout templates, render the document metadata:

```quark
<!DOCTYPE html>
<html lang="<?php echo App::getDocument()->getLang(); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  {{ document.renderHead() }}
</head>
<body>
  {~ outlet ~}
    
  {{ document.renderBodyScripts() }}
</body>
</html>
```

The `renderHead()` method outputs:

- `<title>` tag
- Meta tags (description, keywords, Open Graph, etc.)
- `<link>` tags
- Inline styles
- Scripts marked for `<head>`
- Inline scripts marked for `<head>`

The `renderBodyScripts()` method outputs:

- Scripts marked for the end of `<body>`
- Inline scripts marked for the end of `<body>`
