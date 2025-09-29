# Your First Application

Let's build a simple multi-page site to get familiar with Newtron's core concepts. We'll create a personal portfolio site that demonstrates routing, templates, and working with static content.

## What We'll Build

A simple portfolio site with:

- A homepage with an introduction
- An about page with a bio
- A projects showcase page
- Individual project detail pages

This will introduce you to: 

- File-based routing
- Quark templates and layouts
- Dynamic route parameters
- Document metadata and assets

## Getting Started

Make sure you've completed the [Installation](/getting-started/installation) steps and have a development server running:

```bash
cd public && php -S localhost:8000
```

For this guide, we'll be using Newtron's file-based routing mode because it's the simplest. Make sure your app is set to the file-based routing mode in `config/routing.php`:

```php
return [
  'mode' => 'file',
];
```

We'll also need an updated stylesheet, so go ahead and replace the content of `public/style.css`:

```css
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  line-height: 1.6;
  color: #333;
}

nav {
  background: #667eea;
  padding: 1rem 2rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

nav ul {
  list-style: none;
  display: flex;
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: opacity 0.3s;
}

nav a:hover {
  opacity: 0.8;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 3rem 2rem;
}

.hero {
  text-align: center;
  padding: 4rem 0;
}

.hero h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #667eea;
}

.tagline {
  font-size: 1.5rem;
  color: #666;
  margin-bottom: 2rem;
}

.cta-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

.btn {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 600;
  transition: transform 0.3s, box-shadow 0.3s;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-primary {
  background: #667eea;
  color: white;
}

.btn-secondary {
  background: white;
  color: #667eea;
  border: 2px solid #667eea;
}

.project-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.project-card {
  background: white;
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.project-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.project-card h3 {
  color: #667eea;
  margin-bottom: 0.5rem;
}

.project-card p {
  color: #666;
  margin-bottom: 1rem;
}

.project-card a {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
}
```

## Creating the Homepage Route

Create a new file at `routes/_index.php`:

```php
<?php

use Newtron\Core\Application\App;
use Newtron\Core\Routing\FileRoute;

class Home extends FileRoute {
  public function get() {
    return;
  }

  public function render(mixed $data): mixed {
    App::getDocument()
      ->setTitle('Welcome')
      ->setDescription('Full-stack developer and Newtron expert');

    return Response::create(
      Quark::render('home')
    );
  }
}

return [
  new Home(),
];
```

Let's run through everything this route file is doing:

- **The filename:** We named this file `_index`, which is a special name for the file-based router. This basically tells the router "treat this as the default route for this folder". Since `routes/` is the base directory for routes, this means this file will register as our base route for the `/` path
- **The `get()` function:** By defining this function, we're telling the router to allow GET requests for this route. Similarly, if we wanted to allow POST requests we would simply add a `post()` function.
    - It may not look like this function is actually doing anything, and you're right! We call these HTTP request functions the **Preflight Functions**. They get called before rendering, allowing you to perform some actions based on the request or process some data. Since we're just rendering a static page in this route, we don't need to do any work in the GET preflight function, so we just return immediately. [Learn more about the Preflight Functions](/routing/file-based#preflight-functions)
- **The `render()` function:** This function gets called to display your route. Here we just use set the document's title and description, and return a new Response, with a Quark template for the Response's content.
- **The ending return:** At the end of the file, we return the Route Options array, the first argument of which is an instance of our route. Since this is a very basic route, we don't need to set any additional options!

## Creating the Homepage Template

Our route doesn't do us any good without a template, so let's create one! Create the template at `templates/home.quark.html`:

```twig
{% layout 'layouts.app' %}

{% slot content %}
  <div class="hero">
    <h1>Hi, I'm {{ name }}</h1>
    <p class="tagline">{{ tagline }}</p>
    
    <div class="cta-buttons">
      <a href="/about" class="btn btn-primary">About Me</a>
      <a href="/projects" class="btn btn-secondary">View Projects</a>
    </div>
  </div>
{% endslot %}
```
