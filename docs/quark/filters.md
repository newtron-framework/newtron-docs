# Filters

Quark provides some filter functions you can use when outputting expressions.

## Filter Usage

To pass a value through a filter, you use the pipe character `|`:

```twig
{{ name | upper }}
```

You can chain as many filters together as you like:

```twig
{{ name | upper | reverse }}
```

## upper

Convert a string to uppercase:

```twig
<!-- $test = 'test'; -->
{{ test | upper }}
<!-- Outputs: 'TEST' -->
```

## lower

Convert a string to lowercase:

```twig
<!-- $test = 'TEST'; -->
{{ test | lower }}
<!-- Outputs: 'test' -->
```

## capitalize

Capitalize a string:

```twig
<!-- $test = 'test'; -->
{{ test | capitalize }}
<!-- Outputs: 'Test' -->
```

## length

Get the length of a string:

```twig
<!-- $test = 'test'; -->
{{ test | length }}
<!-- Outputs: 4 -->
```

Or an array:

```twig
<!-- $test = [1, 2, 3]; -->
{{ test | length }}
<!-- Outputs: 3 -->
```

## reverse

Reverse a string:

```twig
<!-- $test = 'test'; -->
{{ test | reverse }}
<!-- Outputs: 'tset' -->
```

Or an array:

```twig
<!-- $test = [1, 2, 3]; -->
{{ test | reverse }}
<!-- Outputs: [3, 2, 1] -->
```

## sort

Sort an array:

```twig
<!-- $test = [2, 3, 1]; -->
{{ test | sort }}
<!-- Outputs: [1, 2, 3] -->
```

## join

Combine an array:

```twig
<!-- $test = [1, 2, 3]; -->
{{ test | join }}
<!-- Outputs: '1, 2, 3' -->
```

With a custom separator:

```twig
<!-- $test = [1, 2, 3]; -->
{{ test | join('.') }}
<!-- Outputs: '1.2.3' -->
```

## default

Provide a default value if the value is empty:

```twig
<!-- $test = ''; -->
{{ test | default('Default') }}
<!-- Outputs: 'Default' -->

<!-- $test = 'Test'; -->
{{ test | default('Default') }}
<!-- Outputs: 'Test' -->
```

## date

Format a date:

```twig
<!-- $test = '12/20/2000'; -->
{{ test | date }}
<!-- Outputs: '2000-12-20' -->
```

With a custom format:

```twig
<!-- $test = '12/20/2000'; -->
{{ test | date('M d, Y') }}
<!-- Outputs: 'Dec 20, 2000' -->
```

## truncate

Truncate a string (default length is 100):

```twig
<!-- $test = '12345678'; -->
{{ test | truncate(4) }}
<!-- Outputs: '1234...' -->
```

## raw

Output a value without escaping it:

```twig
<!-- $test = '<script>alert(1)</script>'; -->
{{ test | raw }}
<!-- Outputs: '<script>alert(1)</script>' -->
```

## json

Output a value as JSON:

```twig
<!-- $test = ['key' => 'value']; -->
{{ test | json }}
<!-- Outputs: '{"key":"value"}' -->
```

## dump

Dump a variable for easy debugging:

```twig
<!-- $test = ['key' => 'value']; -->
{{ test | dump }}
<!-- Outputs: '<pre>Array ( [test] => value )</pre>' -->
```
