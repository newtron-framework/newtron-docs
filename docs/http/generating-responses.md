# Generating Responses

Every route handler in Newtron will return a response. Whether it's HTML, JSON, a redirect, or anything else Newtron provides a consistent API for generating all types of HTTP responses.

## Basic Responses

Return a string directly:

```php
use Newtron\Core\Http\Response;

return Response::create('Hello, World!');
```

To return a Quark template, simply return the Quark render as the response string:

```php
use Newtron\Core\Http\Response;
use Newtron\Core\Quark\Quark;

return Response::create(Quark::render('home'));

// With data
return Response::create(Quark::render('home', ['name' => 'Newt']));
```

Or build your own response explicitly:

```php
// With status code
return Response::create('Not Found', 404);

// With headers
return Response('Hello', 200, [
  'Content-Type' => 'text/plain',
  'X-Custom-Header' => 'value'
]);
```

## JSON Responses

When sending a JSON response, you can just send an array of data directly:

```php
return Response::createJson(['message' => 'Success']);

// With status code
return Response::createJson(['error' => 'Not found'], 404);

// Pretty print
return Response::createJson($data, 200, [], JSON_PRETTY_PRINT);
```

## Redirects

To redirect the user to another page:

```php
return Response::createRedirect('/home');

// To external URL
return Response::createRedirect('https://example.com');
```

You can also redirect with a status code:

```php
// 302 temporary redirect (default)
return Response::createRedirect('/new-page');

// 301 permanent redirect
return Response::createRedirect('/new-page', 301);
```

## Status Codes

Newtron allows you to either define status codes with integers, or by using the `Status` enum:

```php
use Newtron\Core\Http\Status;

// 200 OK
Status::OK

// 201 Created
Status::CREATED

// 204 No Content
Status::NO_CONTENT

// 400 Bad Request
Status::BAD_REQUEST

// 401 Unauthorized
Status::UNAUTHORIZED

// 403 Forbidden
Status::FORBIDDEN

// 404 Not Found
Status::NOT_FOUND

// 500 Internal Server Error
Status::INTERNAL_ERROR
```

## Cookies

To set cookies for a response:

```php
return Response::create('Hello')->setCookie(
  'name',
  'value',
  600       // 10 minutes
);

// With additional options
return Response::create('Hello')->setCookie(
    'name',           // Name
    'value',          // Value
    600,              // Expire time (seconds)
    '/',              // Path
    'example.com',    // Domain
    true,             // Secure (HTTPS only)
    true              // HTTP only
);
```
