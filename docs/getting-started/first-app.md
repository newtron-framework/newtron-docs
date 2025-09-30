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

We'll also need an updated stylesheet, so grab the [CSS from the repo](https://github.com/newtron-framework) for this example project and replace the content of `public/style.css`.

## Creating the Homepage Route

Create a new file at `routes/_index.php`:

```php
<?php

use Newtron\Core\Application\App;
use Newtron\Core\Http\Response;
use Newtron\Core\Quark\Quark;
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
      Quark::render('home', [
        'name' => 'Your Name',
        'tagline' => 'Full-stack developer & Newtron expert',
      ])
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
    - We also pass a data array to the Quark template. This will make our custom values available as `name` and `tagline` variables in the template.
- **The ending return:** At the end of the file, we return the Route Options array, the first argument of which is an instance of our route. Since this is a very basic route, we don't need to set any additional options!

## Creating the Homepage Template

Our route doesn't do us any good without a template, so let's create one! Create the template at `templates/home.quark.html`:

```twig
{% layout 'layouts.app' %}

<div class="hero">
  <h1>Hi, I'm {{ name }}</h1>
  <p class="tagline">{{ tagline }}</p>
  
  <div class="cta-buttons">
    <a href="/about" class="btn btn-primary">About Me</a>
    <a href="/projects" class="btn btn-secondary">View Projects</a>
  </div>
</div>
```

For the most part, the template is standard HTML. But there are a few Quark things to take note of:

- **The `layout`:** At the top of the file we define a layout for this template. With this, we're telling Quark to use our template as the child for the given layout template.
- **The variable expressions:** We also make use of the data we passed in our route's render function. With `{{ name }}` and `{{ tagline }}`, we output the matching values from the data array.

## Creating the Layout

In our template, we defined a parent layout so let's create the file for that layout template! In our case, we set the layout to `layouts.app`, which will translate to the file `templates/layouts/app.quark.html`:

```twig
<nav>
  <ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
    <li><a href="/projects">Projects</a></li>
  </ul>
</nav>

<div class="container">
  {% outlet %}
</div>
```

This template is pretty simple. We just define a navbar, and use `{% outlet %}` to render the child template's content. Layouts like this are handy, because we can define our site's layout once and use it to wrap every page's content without having to repeat code.

We now have all of the pieces in place, so visit `http://localhost:8000` and you should see your homepage!

## Adding an About Page

Let's add an about page to give visitors some more information.

Like before, we create a new route file `routes/about.php`:

```php
<?php

use Newtron\Core\Application\App;
use Newtron\Core\Http\Response;
use Newtron\Core\Quark\Quark;
use Newtron\Core\Routing\FileRoute;

class About extends FileRoute {
  public function get(): array {
    $skills = ['PHP', 'JavaScript', 'HTML/CSS', 'Newtron'];
    $experience = [
      [
        'role' => 'Senior Developer',
        'company' => 'Tech Company',
        'period' => '2020 - present',
        'description' => 'Led development of scalable web applications',
      ],
      [
        'role' => 'Developer',
        'company' => 'Startup Inc',
        'period' => '2018 - 2020',
        'description' => 'Built features for growing SaaS platform',
      ],
    ];

    return [
      'skills' => $skills,
      'experience' => $experience,
    ];
  }

  public function render(mixed $data): mixed {
    App::getDocument()
      ->setTitle('About Me')
      ->setDescription('Learn more about my background and experience');

    return Response::create(
      Quark::render('about', $data)
    );
  }
}

return [
  new About(),
];
```

This time we're returning some data from our Preflight Function! Usually you might pull in data from an external source, but for our example we'll just hard code some data. The return value of our Preflight Function is passed to the render function as the `$data` parameter, so we can just pass that straight to the Quark template.

And of course we'll need to create a template at `templates/about.quark.html`:

```twig
{% layout 'layouts.app' %}

<h1>About Me</h1>

<div style="max-width: 800px;">
  <p style="font-size: 1.2rem; color: #666; margin: 2rem 0;">
    I'm a passionate developer who loves building elegant solutions to complex problems.
    I specialize in creating web applications that are both powerful and user-friendly.
  </p>

  <h2 style="margin-top: 3rem; color: #667eea;">Skills</h2>
  <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
    {% foreach $skills as $skill %}
    <span style="background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px;">
      {{ skill }}
    </span>
    {% endforeach %}
  </div>

  <h2 style="margin-top: 3rem; color: #667eea;">Experience</h2>
  <div style="margin-top: 2rem;">
    {% foreach $experience as $job %}
    <div style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
      <h3>{{ job.role }}</h3>
      <p style="color: #667eea; font-weight: 600;">
        {{ job.company }} • {{ job.period }}
      </p>
      <p style="color: #666; margin-top: 0.5rem;">
        {{ job.description }}
      </p>
    </div>
    {% endforeach %}
  </div>
</div>
```

Again, mostly standard HTML but in this template we're taking advantage of Quark's `foreach` loop. We loop over the skills and experience data we passed in, repeating a snippet of HTML for each item.

You should now be able to see your about page rendered with the data we passed at `http://localhost:8000/about`!

## Creating a Projects Showcase

Next up we'll need a page to showcase all of our projects. This will function very similarly to the about page.

First, we need the route. We'll use the special `_index` name again, and create it at `routes/projects/_index.php` so we can access it at `/projects`:

```php
<?php

use Newtron\Core\Application\App;
use Newtron\Core\Http\Response;
use Newtron\Core\Quark\Quark;
use Newtron\Core\Routing\FileRoute;

class Projects extends FileRoute {
  public function get(): array {
    $projects = [
      [
        'id' => 'task-manager',
        'title' => 'Task Manager',
        'description' => 'A beautiful task management application built with Newtron',
        'tech' => ['PHP', 'JavaScript', 'CSS'],
      ],
      [
        'id' => 'blog-platform',
        'title' => 'Blog Platform',
        'description' => 'Modern blogging platform with Markdown support',
        'tech' => ['PHP', 'Newtron', 'Markdown'],
      ],
      [
        'id' => 'api-service',
        'title' => 'REST API Service',
        'description' => 'RESTful API with authentication and rate limiting',
        'tech' => ['PHP', 'JSON', 'OAuth'],
      ],
    ];

    return ['projects' => $projects];
  }

  public function render(mixed $data): mixed {
    App::getDocument()
      ->setTitle('Projects')
      ->setDescription('Check out some of my recent work');

    return Response::create(
      Quark::render('projects.showcase', $data)
    );
  }
}

return [
  new Projects(),
];
```

And the cooresponding template at `templates/projects/showcase.quark.html`:

```twig
{% layout 'layouts.app' %}

<h1>My Projects</h1>
<p style="font-size: 1.2rem; color: #666; margin-bottom: 2rem;">
  Here are some of the projects I've worked on recently.
</p>

<div class="project-grid">
  {% foreach $projects as $project %}
  <div class="project-card">
    <h3>{{ project.title }}</h3>
    <p>{{ project.description }}</p>
    
    <div style="margin: 1rem 0;">
      {% foreach $project['tech'] as $tech %}
      <span style="display: inline-block; background: #f0f0f0; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.85rem; margin-right: 0.5rem;">
        {{ tech }}
      </span>
      {% endforeach %}
    </div>
    
    <a href="/projects/{{ project.id }}">View Details →</a>
  </div>
  {% endforeach %}
</div>
```

## Adding Dynamic Project Pages

Now let's create individual pages for our projects. We *could* create a new route for every project, but that doesn't scale well. Instead, we'll use **Dynamic Routing**.

All of our projects will have a URL like `/projects/[id]`, where `[id]` is the project's ID. We can achieve this by creating a dynamic route at `routes/projects/[id].php`:

```php
<?php

use Newtron\Core\Application\App;
use Newtron\Core\Error\HttpException;
use Newtron\Core\Http\Response;
use Newtron\Core\Http\Status;
use Newtron\Core\Quark\Quark;
use Newtron\Core\Routing\FileRoute;

class Project extends FileRoute {
  public function get(string $id): array {
    $projects = [
      'task-manager' => [
        'title' => 'Task Manager App',
        'description' => 'A beautiful task management application built with Newtron',
        'tech' => ['PHP', 'JavaScript', 'CSS'],
        'details' => 'This project demonstrates the power of Newtron\'s routing and templating system. It features a clean, modern interface with smooth interactions.',
        'features' => [
          'Create and manage tasks',
          'Mark tasks as complete',
          'Filter and search functionality',
          'Responsive design'
        ]
      ],
      'blog-platform' => [
        'title' => 'Blog Platform',
        'description' => 'Modern blogging platform with markdown support',
        'tech' => ['PHP', 'Newtron', 'Markdown'],
        'details' => 'A full-featured blogging platform that makes writing and publishing content easy. Built with Newtron for maximum performance.',
        'features' => [
          'Markdown editor',
          'Tag system',
          'RSS feed generation',
          'SEO optimization'
        ]
      ],
      'api-service' => [
        'title' => 'REST API Service',
        'description' => 'RESTful API with authentication and rate limiting',
        'tech' => ['PHP', 'JSON', 'OAuth'],
        'details' => 'A robust API service with enterprise-grade security and performance. Handles thousands of requests per second.',
        'features' => [
          'OAuth 2.0 authentication',
          'Rate limiting',
          'API versioning',
          'Comprehensive documentation'
        ]
      ],
    ];

    $project = $projects[$id] ?? null;

    if ($project === null) {
      throw new HttpException(Status::NOT_FOUND);
    }

    return ['project' => $project];
  }

  public function render(mixed $data): mixed {
    App::getDocument()
      ->setTitle($data['project']['title'])
      ->setDescription($data['project']['description']);

    return Response::create(
      Quark::render('projects.details', $data)
    );
  }
}

return [
  new Project(),
];
```

Here we're defining some hard coded data again, this would most likely come from an external source.

This time we're taking an argument in our Preflight `get()` function: `$id`. This matches the dynamic segment in our route (`[id]`), and will be populated with the value of that segment. So we can just take that ID and get the matching project data for the requested route! If we don't have a matching project, we can throw an `HTTPException` with the `NOT_FOUND` status code (404). This will automatically get handled by Newtron and display a 404 error page.

Again we'll create a simple template for our page at `templates/projects/details.quark.html`:

```twig
{% layout 'layouts.app' %}

<a href="/projects" style="color: #667eea; text-decoration: none; display: inline-block; margin-bottom: 2rem;">
  ← Back to projects
</a>

<h1>{{ project.title }}</h1>

<div style="margin: 1rem 0;">
  {% foreach $project['tech'] as $tech %}
  <span
    style="display: inline-block; background: #667eea; color: white; padding: 0.5rem 1rem; border-radius: 20px; margin-right: 0.5rem;">
    {{ tech }}
  </span>
  {% endforeach %}
</div>

<div style="max-width: 800px; margin-top: 2rem;">
  <p style="font-size: 1.2rem; color: #666;">{{ project.description }}</p>

  <h2 style="margin-top: 3rem; color: #667eea;">About This Project</h2>
  <p style="color: #666; margin-top: 1rem;">{{ project.details }}</p>

  <h2 style="margin-top: 3rem; color: #667eea;">Key Features</h2>
  <ul style="margin-top: 1rem;">
    {% foreach $project['features'] as $feature %}
    <li style="color: #666; margin-bottom: 0.5rem;">{{ feature }}</li>
    {% endforeach %}
  </ul>
</div>
```

Now you can visit `/projects/task-manager`, `/projects/blog-platform`, etc. to view individual project details!

## Understanding What You Built

Here's what's happening in your portfolio site:

1. **File-based routing:** Each `.php` file in `routes/` becomes a route automatically
2. **Dynamic parameters:** `[id].php` captures the URL segment as a variable
5. **Data passing:** Route files prepare data with Preflight Functions and pass it to templates
3. **Template inheritance:** All pages extend the `layouts.app` template for consistent design
4. **Document metadata:** Each page sets its own title and description

## Try It With Declarative Routes

If you prefer a more declarative routing style, you can easily convert this to use the declarative routing mode! As an example, here's what our homepage route would look like as a declarative route:

```php
Route::get('/', function () {
  App::getDocument()
    ->setTitle('Welcome')
    ->setDescription('Full-stack developer and Newtron expert');

  return Response::create(
    Quark::render('home', [
      'name' => 'Your Name',
      'tagline' => 'Full-stack developer & Newtron expert',
    ])
  );
});
```

If you'd like to explore converting this to declarative routes, update your `config/routing.php` and [learn more about declarative routing](/routing/declarative):

```php
return [
  'mode' => 'declarative',
];
```

## What You've Learned

Congratulations! You've built a complete portfolio site with Newtron. You now know how to:

- Create pages using file-based routing
- Use dynamic route parameters like `[id]`
- Work with Quark templates and layouts
- Use control structures in Quark templates (if, foreach)
- Pass data from routes to templates
- Set page titles and metadata with the Document interface
- Handle 404 errors gracefully
- Choose between file-based or declarative routing

## Next Steps

Now that you've mastered the basics, explore these topics:

- [Routing](/routing/introduction) - Learn about the routing modes, middleware, and advanced patterns
- [Quark Templates](/quark/template-basics) - Discover filters, slots, and advanced syntax
- [Document & Assets](/document/document-management) - Learn how to manage document metadata and assets
- [HTTP](/http/request-handling) - Deep dive into requests, responses, and middleware

The best way to learn is by building. Have fun experimenting with Newtron!

## Try It Yourself

Here are some ways you can challenge yourself to extend this portfolio:

1. Add a contact page with your email and social links
2. Create a blog section with individual post pages
3. Add a custom 404 error page
4. Include external CSS or JavaScript files
5. Add images to your project pages

## What's Coming

In Phase 3, you'll be able to easily enhance this site with:

- Database support - Store projects in a database instead of arrays
- Contact forms - Add a working contact form with validation
- Admin panel - Manage your portfolio content through a web interface

Keep an eye on the [Roadmap](https://newtron.app/roadmap) to see what's coming to Newtron next!
