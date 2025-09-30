# Directives

For more complex template logic, Quark provides directives you can use to control your templates.

## layout

Set a parent layout for the template:

```twig
{% layout 'layouts.app' %}
```

## skip_root

Skip the Root Layout when rendering the template:

```
{% skip_root %}
```

## outlet

Render the content of a child template:

```twig
{% outlet %}
```

Or render the [content of a named slot](/quark/layouts-inheritance#named-outlets) in a child template:

```twig
{% outlet custom %}
```

## slot, endslot

Define content for a [slot](/quark/layouts-inheritance#slots):

```twig
{% slot custom %}
<p>Slot content</p>
{% endslot %}
```

## include

Include another template within the current template:

```twig
{% include 'nested.item' %}
```

## if, else, elseif, endif

```twig
{% if $role === 'admin' %}
<p>Hello, admin!</p>
{% elseif $role === 'member' %}
<p>Hello, member!</p>
{% else %}
<p>Hello, guest!</p>
{% endif %}
```

## foreach, endforeach

```twig
{% foreach $items as $item %}
<p>{{ item.name }}</p>
{% endforeach %}
```

## set

Set a variable value:

```twig
{% set $name = 'Newtron' %}
<p>{{ name }}</p>
```
