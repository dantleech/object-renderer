<?php

namespace Phpactor\ObjectRenderer\Tests\Adapter\Twig;

use Closure;
use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Adapter\Twig\TwigObjectRenderer;
use Phpactor\ObjectRenderer\Model\TemplateProvider\ClassNameTemplateProvider;
use Phpactor\ObjectRenderer\Tests\IntegrationTestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use stdClass;

class TwigObjectRendererTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideRender
     * @param array<string, string> $templates
     */
    public function testRender(string $stub, array $templates, string $expected): void
    {
        $oect = $this->loadStub($stub);
        $loader = new ArrayLoader($templates);
        $resolver = new ClassNameTemplateProvider();
        $renderer = new TwigObjectRenderer(new Environment($loader), $resolver);
        self::assertEquals($expected, $renderer->render($oect));
    }

    /**
     * @return Generator<array>
     */
    public function provideRender(): Generator
    {
        yield 'render simple oect' => [
            '<?php $o = new stdClass(); $o->foobar = "Barfoo"; return $o;',
            [
                'stdClass' => '{{ object.foobar }}'
            ],
            'Barfoo'
        ];

        yield 'render a sub-object from in the template' => [
            '<?php $o = new stdClass(); $o->hello = "hello";$o->foobar = new stdClass();$o->foobar->hello="goodbye"; return $o;',
            [
                'stdClass' => '{{ object.hello }}{{ render(object.foobar) }}'
            ],
            'hellogoodbye'
        ];
    }
}
