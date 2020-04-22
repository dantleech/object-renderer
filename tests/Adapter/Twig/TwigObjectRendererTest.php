<?php

namespace Phpactor\ObjectRenderer\Tests\Adapter\Twig;

use Closure;
use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Adapter\Twig\TwigObjectRenderer;
use Phpactor\ObjectRenderer\Mode\TemplateResolver\ClassNameTemplateResolver;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use stdClass;

class TwigObjectRendererTest extends TestCase
{
    /**
     * @dataProvider provideRender
     * @param array<string, string> $templates
     */
    public function testRender(Closure $factory, array $templates, string $expected): void
    {
        $loader = new ArrayLoader($templates);
        $resolver = new ClassNameTemplateResolver();
        $renderer = new TwigObjectRenderer(new Environment($loader), $resolver);
        self::assertEquals($expected, $renderer->render($factory()));
    }

    /**
     * @return Generator<array>
     */
    public function provideRender(): Generator
    {
        yield 'render simple object' => [
            function () {
                $object = new stdClass();
                $object->foobar = 'Barfoo';

                return $object;
            },
            [
                'stdClass' => '{{ object.foobar }}'
            ],
            'Barfoo'
        ];

        yield 'render a sub-object from in the template' => [
            function () {
                $object = new stdClass();
                $object->foobar = new stdClass();

                return $object;
            },
            [
                'stdClass' => '{{ render(object.foobar) }}'
            ],
            'Barfoo'
        ];
    }
}
