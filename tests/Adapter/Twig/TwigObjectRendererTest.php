<?php

namespace Phpactor\ObjectRenderer\Tests\Adapter\Twig;

use Closure;
use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Adapter\Twig\TwigObjectRenderer;
use Phpactor\ObjectRenderer\Model\TemplateResolver\ClassNameTemplateResolver;
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
        $object = $this->loadStub($stub);
        $loader = new ArrayLoader($templates);
        $resolver = new ClassNameTemplateResolver();
        $renderer = new TwigObjectRenderer(new Environment($loader), $resolver);
        self::assertEquals($expected, $renderer->render($object));
    }

    /**
     * @return Generator<array>
     */
    public function provideRender(): Generator
    {
        yield 'render simple object' => [
            'SingleObject.php.stub',
            [
                'stdClass' => '{{ object.foobar }}'
            ],
            'Barfoo'
        ];

        yield 'render a sub-object from in the template' => [
            'ComplexObject.php.stub',
            [
                'stdClass' => '{{ object.hello }}{{ render(object.foobar) }}'
            ],
            'hellogoodbye'
        ];
    }
}
