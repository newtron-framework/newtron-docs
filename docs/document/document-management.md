# Document Management

Newtron provides a way to interface with the HTML document to easily set metadata and manage assets.

## Getting the Document

To access the Document interface:

```php
<?php

use Newtron\Core\Application\App;

App::getDocument();
```

## Setting Document Metadata

The Document provides methods for setting the document title, description, language, and favicon:

```php
App::getDocument()->setTitle('My Page');

App::getDocument()->setDescription('This is built with Newtron');

App::getDocument()->setLang('en');

App::getDocument()->setFavicon('/custom-icon.ico');
```

You can also directly set `<meta>` tags:

```php
App::getDocument()->setMeta('keywords', 'PHP, Framework, Newtron');
// <meta name="keywords" content="PHP, Framework, Newtron">

// Or use a custom attribute
App::getDocument()->setMeta('refresh', '30', 'http-equiv');
// <meta http-equiv="refresh" content="30">
```

## Setting Open Graph

There is a specific helper function to set Open Graph properties:

```php
App::getDocument()->setOG('image', '/my-og-img.jpg');
// <meta name="og:image" content="/my-og-img.jpg">
```

## Adding Links

To add a link to the document head:

```php
App::getDocument()->addLink('/favicon-32x32.png', 'icon', [
  'type' => 'image/png',
  'sizes' => '32x32',
]);
// <link href="/favicon-32x32.png" rel="icon" type="image/png" sizes="32x32">
```

## Add CSS

To add a CSS stylesheet to the document:

```php
App::getDocument()->addStylesheet('/custom.css');
```

Or add an inline style:

```php
App::getDocument()->addInlineStyle("
.box {
  border: 1px solid red;
}
");
```

## Add JavaScript

To add a script to the document:

```php
// Add script to the <head>
App::getDocument()->addScript('custom.js', ['defer' => 'defer']);

// Pass 'true' for the third argument to add the script to the end of <body>
App::getDocument()->addScript('custom.js', ['defer' => 'defer'], true);
```

Or add an inline script:

```php
// Add inline script to the <head>
App::getDocument()->addInlineScript('alert(1);', ['defer' => 'defer']);

// Pass 'true' for the third argument to add the inline script to the end of <body>
App::getDocument()->addInlineScript('alert(1);', ['defer' => 'defer'], true);
```
