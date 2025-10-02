<p align="center">
  <a href="https://newtron.app" target="_blank">
    <img src="https://raw.githubusercontent.com/newtron-framework/assets/master/newtron-logo.png" alt="newtron" />
  </a>
</p>

The official documentation website for [Newtron](https://github.com/newtron-framework/newtron), built with Newtron.

## About Newtron

Newtron is a PHP framework built around one core principle: complex features should require embarrassingly simple code.
It's built to solve real developer pain points by making common, complex tasks trivially simple.

## What This Is

This repository contains the source files for Newtron's documentation website, including:

- Getting Started guides
- Core documentation
- Tutorials and examples
- Architecture explanations

## Local Development

# Newtron Documentation

The official documentation website for [Newtron](https://github.com/newtron/core) - a PHP framework built around the principle of "complex features with embarrassingly simple code."

**Live site:** [newtron.dev](https://newtron.dev) *(update with actual URL)*

## What This Is

This repository contains the source files for Newtron's documentation website, including:

- Getting Started guides
- Complete API documentation
- Tutorials and examples
- Architecture explanations
- Contribution guidelines

## Local Development

### Prerequisites

- PHP 8.3+
- Composer
- Git

### Setup

```bash
# Clone the repository
git clone https://github.com/newtron-framework/newtron-docs.git
cd newtron-docs

# Install dependencies
composer install

# Start development server
cd public && php -S localhost:8000
```

The site will be available at `http://localhost:8000`.

## Documentation Structure

The documentation is made up of Markdown files in the `docs/` directory, and the file paths within `docs/` are used for the URL. 

The sidebar menu is defined in `app/SidebarStructure.php`.

## Contributing

Any contributions to improve the documentation are welcome! Here's how:

### Fixing Typos or Small Errors

1. Click "Edit this page" at the bottom of any documentation page
2. Make your changes
3. Submit a pull request

### Adding New Content

1. Fork this repository
2. Create a new branch: `git checkout -b docs/my-improvement`
3. Make your changes following our [style guide](#style-guide)
4. Test locally
5. Submit a pull request with a clear description

### Reporting Issues

Found a problem? [Open an issue](https://github.com/newtron-framework/newtron-docs/issues) with:

- What's wrong or unclear
- Which page it's on
- Suggestions for improvement (if any)

## Style Guide

### Writing Style

- **Be conversational:** Write like you're explaining to a friend
- **Be practical:** Focus on real use cases, not abstract concepts
- **Be concise:** Respect the reader's time
- **Show and explain:** Use code examples liberally, but be sure to explain deeper concepts
- **Be honest:** If something is coming later, say so

### Code Examples

- Include complete, working examples
- Use realistic variable names and scenarios
- Add comments for clarity, but don't over-comment
- Show both simple and advanced usage when relevant

```php
// Good - complete and practical
$form = Form::new()
  ->field('email')->required()->email()
  ->field('password')->required()->min(8);

if ($form->submitted() && $form->valid()) {
  Auth::login($form->data());
}

// Bad - too abstract
$x = SomeClass::create($y);
if ($x->check()) {
  $x->process();
}
```

### Formatting

- Use H1 (`#`) for page title only
- Use H2 (`##`) for main sections
- Use H3 (`###`) for subsections
- Use code blocks with language specified: ` ```php `
- Use inline code for: commands, file paths, class names, method names
- Bold key, Newtron-specific concepts on first use
- Use lists for steps or collections of items

### Structure

Every documentation page should include:

1. **Brief introduction:** What this page covers
2. **Core content:** Organized by topic/complexity
3. **Code examples:** Practical, copy-paste ready

Avoid:
- "What's coming" sections (save for roadmap)
- "Best practices" sections (integrate into content)
- "Common patterns" dumps (show in context)

## Getting Help

- **General questions:** [GitHub Discussions](https://github.com/newtron-framework/newtron/discussions)
- **Documentation issues:** [Open an issue](https://github.com/newtron-framework/newtron-docs/issues)
