# Error Pages

When something goes wrong, show your users a helpful, branded error page instead of a generic browser error. Newtron makes it easy to customize error pages for different HTTP status codes.

## Default Error Pages

Newtron includes default error pages for common status codes:

- **404:** Not Found
- **500:** Internal Server Error

These work out of the box, but you'll want to customize them to match your site's design.

## Creating Custom Error Pages

Custom error pages are just Quark templates! You can create them in the `templates/` directory:

```bash
templates/
└── errors/
    ├── 404.quark.html
    ├── 403.quark.html
    ├── 500.quark.html
    └── 503.quark.html
```

Then register the custom error page with the application:

```php
use Newtron\Core\Application\App;
use Newtron\Core\Http\Status;

// Use the 'Status' enum, or raw status codes
App::setErrorPage(Status::NOT_FOUND, 'errors.404');
App::setErrorPage(500, 'errors.500');
```

## Returning Error Responses

Newtron makes it easy to trigger error responses with the `HttpException`. Just throw a new `HttpException` with the status code and Newtron will handle rendering the correct error page.

```php
use Newtron\Core\Error\HttpException;
use Newtron\Core\Http\Status;

// 404 Not Found
throw new HttpException(Status::NOT_FOUND);

// 403 Forbidden
throw new HttpException(Status::FORBIDDEN);

// 500 Internal Server Error
throw new HttpException(Status::INTERNAL_ERROR);

// Any custom status code
throw new HttpException(418);
```
