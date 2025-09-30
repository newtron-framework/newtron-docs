# Introduction to Routing in Newtron

Routing is how Newtron maps URLs to the code that handles them. Newtron supports two distinct routing modes: **File-based** routing and **Declarative** routing.

## File-Based Routing

Create a file, get a route. It's that simple.

| File Path | Matching Route URL |
| --- | --- |
| `routes/about.php` | `/about` |
| `routes/blog/[slug].php` | `/blog/hello-world` |
| `routes/users/[id]/edit.php` | `/uses/123/edit` |

Example file-based route:

```php
<?php

class BlogPost extends FileRoute {
  public function get(string $slug): array {
    $blogPost = $db->getBlogPost($slug); // Just an example, you would load data however you need

    return [
      'post' => $blogPost,
    ];
  }

  public function render(mixed $data): mixed {
    return Response::create(
      Quark::render('blog.post', $data);
    );
  }
}

return [new BlogPost()];
```

File-based routing is best for:

- Quick prototyping
- Content-heavy sites
- When file structure mirrors URL structure
- Developers who prefer convention over configuration

## Declarative Routing

Explicitly define routes in code.

Example declarative route:

```php
<?php

Route::get('/blog/{slug}', function (string $slug) {
  $blogPost = $db->getBlogPost($slug); // Just an example, you would load data however you need

  return Response::create(
    Quark::render('blog.post', ['post' => $blogPost])
  );
});
```

Declarative routing is best for:

- Complex routing logic
- When you need fine-grained control
- Developers who prefer configuration over convention

## Choosing Your Routing Mode

Choosing the routing mode you use mostly comes down to preference. Both the file-based and declarative routers support the same features, so you're not missing out on anything if you pick one or the other.

To set your routing mode, change the `mode` option in `config/routing.php`:

```php
// For file-based routing
'mode' => 'file',

// For declarative routing
'mode' => 'declarative',
```

## How Routing Works

When a request comes in, here's what happens:

1. **A Request arrives:** Newtron receives an HTTP request
2. **Route matching:** The router checks for a route that matches the incoming request
3. **Parameter extraction:** Dynamic route segments are captured
4. **Handler execution:** Your route code runs
5. **Response returned:** Output is sent back to the browser

## Quick Comparison

| Feature | File-Based | Declarative |
| --- | --- | --- |
| Route setup | Create file | Register route |
| Dynamic params | `[param]` | `{param}` |
| HTTP methods | Define another function | Register another handler |
| Route names | Generated from file path | Explicitly defined |
| Best for | Content pages | APIs, complex logic |

## Next Steps

Dive deeper into each routing style:

- [File-Based Routing](/routing/file-based)
- [Declarative Routing](/routing/declarative)
