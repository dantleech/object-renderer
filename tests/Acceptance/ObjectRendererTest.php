<?php

namespace Phpactor\ObjectRenderer\Tests\Acceptance;

use DOMDocument;
use Phpactor\ObjectRenderer\ObjectRendererBuilder;
use Phpactor\ObjectRenderer\Tests\IntegrationTestCase;

class ObjectRendererTest extends IntegrationTestCase
{
    public function testRenderObject(): void
    {
        $renderer = ObjectRendererBuilder::create()
            ->addTemplatePath(__DIR__ . '/Example')
            ->build();

        $dom = new DOMDocument();
        $child1 = $dom->createElement('child-1');
        $child1->setAttribute('foo', 'bar');
        $dom->appendChild($child1);
        $child2 = $dom->createElement('child-2');
        $child2->setAttribute('bar', 'foo');
        $dom->appendChild($child2);

        $rendered = $renderer->render($dom);

        self::assertEquals(<<<'EOT'
DOMDocument:
    - Element: "child-1"
      foo: bar
    - Element: "child-2"
      bar: foo

EOT
, $rendered);

    }
}
