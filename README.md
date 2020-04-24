Object Renderer
===============

[![Build Status](https://travis-ci.org/phpactor/object-renderer.svg?branch=master)](https://travis-ci.org/phpactor/indexer-extension)

Render / pretty print objects using Twig templates.

- Templates are selected based on the FQN.
- Templates are resolved based on the class hierarchy.
- Templates can render objects.

Usage
-----

File paths are resolved based on the FQN of the object you want to render.

Create an object renderer with the builder:

```php
$renderer = ObjectRendererBuilder::create()
    ->addTemplatePath('/example/path')
    ->build();
```

Now, imagine we have the following templates in `/example/path`:

```
# DOMDocument.twig
DOMDocument:
{% for node in object.childNodes %}
    - {{ render(node) }}
{%- endfor -%}
```

```
# DOMElement.twig
Element: "{{ object.nodeName }}"
{% for attribute in object.attributes %}
      {{ render(attribute) }}
{%- endfor -%}
```

```
# DOMAttr.twig
{{ object.name }}: {{ object.value }}
```

We can then render a any of these elements, for example to render the
DOMDocument:

```php
$dom = new DOMDocument();
$child1 = $dom->createElement('child-1');
$child1->setAttribute('foo', 'bar');
$dom->appendChild($child1);
$child2 = $dom->createElement('child-2');
$child2->setAttribute('bar', 'foo');
$dom->appendChild($child2);

$rendered = $renderer->render($dom);
```

Should yield something like:

```
DOMDocument:
    - Element: "child-1"
      foo: bar
    - Element: "child-2"
      bar: foo
```
