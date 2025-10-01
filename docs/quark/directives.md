# Directives

For more complex template logic, Quark provides directives you can use to control your templates.

## layout

Set a parent layout for the template:

```quark
{~ layout 'layouts.app' ~}
```

## skip_root

Skip the Root Layout when rendering the template:

```
{~ skip_root ~}
```

## outlet

Render the content of a child template:

```quark
{~ outlet ~}
```

Or render the [content of a named slot](/quark/layouts-inheritance#named-outlets) in a child template:

```quark
{~ outlet custom ~}
```

## slot, endslot

Define content for a [slot](/quark/layouts-inheritance#slots):

```quark
{~ slot custom ~}
<p>Slot content</p>
{~ endslot ~}
```

## include

Include another template within the current template:

```quark
{~ include 'nested.item' ~}
```

## if, else, elseif, endif

```quark
{~ if $role === 'admin' ~}
<p>Hello, admin!</p>
{~ elseif $role === 'member' ~}
<p>Hello, member!</p>
{~ else ~}
<p>Hello, guest!</p>
{~ endif ~}
```

## foreach, endforeach

```quark
{~ foreach $items as $item ~}
<p>{{ item.name }}</p>
{~ endforeach ~}
```

## set

Set a variable value:

```quark
{~ set $name = 'Newtron' ~}
<p>{{ name }}</p>
```
