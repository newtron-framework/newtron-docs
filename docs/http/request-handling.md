---
description: "Access request data in Newtron: input, files, headers, cookies. Complete guide to working with HTTP requests."
---

# Request Handling

Newtron's Request object provides a clean interface for working with incoming HTTP requests. Easily access query parameters, form data, uploaded files, headers, and any request info.

## Accessing the Request

The Request object is made available through the `App` class:

```php
<?php

use Newtron\Core\Application\App;

$request = App::getRequest();
```

## Retrieving Input

Retrieve any input value from the request:

```php
// Get from query string or POST data
$name = $request->input('name');

// With default value
$page = $request->input('page', 1);
$sort = $request->input('sort', 'created_at');
```

The `input()` method checks both `$_GET` and `$_POST`.

## Query Parameters

Access query string parameters specifically:

```php
// URL: /search?q=newtron&page=2

$query = $request->query('q');        // 'newtron'
$page = $request->query('page');      // '2'

// Get all query parameters
$queryParams = $request->query();     // ['q' => 'newtron', 'page' => '2']
```

## POST Data

Access POST data specifically:

```php
$name = $request->data('name');
$email = $request->data('email');

// Get all POST data
$postData = $request->data();
```

## Request Method

To get the HTTP method:

```php
$method = $request->getMethod();  // 'GET', 'POST', etc.
```

You can also directly check if the request matches a certain method:

```php
if ($request->isMethod('post')) {
  // Handle POST request
}
```

## Request Path and URL

### Current Path

```php
// URL: https://example.com/blog/post?page=2

$path = $request->path();  // '/blog/post'
```

### Current URL

```php
// Full URL with query string
$url = $request->url();  // 'https://example.com/blog/post?page=2'

// URL without query string
$url = $request->urlWithoutQuery();  // 'https://example.com/blog/post'
```

## Headers

Check the request headers:

```php
$userAgent = $request->getHeader('User-Agent');
$contentType = $request->getHeader('Content-Type');

// With default value
$accept = $request->getHeader('Accept', 'text/html');

// Get all headers
$headers = $request->getHeaders();
```

## Cookies

Get cookie values from the request:

```php
$theme = $request->getCookie('theme');
$sessionId = $request->getCookie('session_id');

// With default value
$lang = $request->getCookie('language', 'en');

// Get all cookies
$cookies = $request->getCookies();
```

## Uploaded Files

Get an uploaded file:

```php
$avatar = $request->getFile('avatar');
```

Or get all files in the request:

```php
$files = $request->getFiles();
```

## Request Content

Get the raw request body:

```php
$content = $request->getBody();
```

For JSON requests, parse the JSON body:

```php
// For Content-Type: application/json
$data = $request->getJson();
```

## IP Address

Attempt to retrieve the client's IP address:

```php
$ip = $request->getIP();
```

## User Agent

Get the user agent string from the request:

```php
$userAgent = $request->getUserAgent();
```

## AJAX Requests

You can check if a request is an AJAX request to handle the response appropriately:

```php
if ($request->ajax()) {
  return Response::createJson(...);
}
```

## Request in Templates

The request is made available as a global variable in Quark templates:

```quark
<!-- Check if search was submitted -->
{~ if $request->query('search', false) ~}
  <p>Search results for: {{ request.query('search') }}</p>
{~ endif ~}

<!-- Display current page -->
<p>Page {{ request.query('page', 1) }}</p>
```
