Object Renderer
===============

[![Build Status](https://travis-ci.org/phpactor/object-renderer.svg?branch=master)](https://travis-ci.org/phpactor/indexer-extension)

Render / pretty print objects.

This library renders objects using Twig. 

- Templates are selected based on the FQN.
- Templates are resolved based on the class hierarchy.
- Templates can render objects.

Example
-------

```
# ReflectionClass.php.twig
This is class: {{ object.name }}

It has methods:
{% for method in object.methods %}
    - {{ render(method) }}
{% endfor %}
```

```
# ReflectionMethod.php.twig
{{ object.name }}(): {{ object.returnType }}
```

```
$reflection = new ReflectionClass(new Request(200));

// $renderer = ...
$rendered = $renderer->render($reflection);
```

Would render something like:

```
This is class: Symfony\HttpFoundation\Request

It has methods:

- getPathInfo(): string
- getHeaders(): array
- ...
```
