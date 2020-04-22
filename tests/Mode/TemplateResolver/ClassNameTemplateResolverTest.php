<?php

namespace Phpactor\ObjectRenderer\Tests\Mode\TemplateResolver;

use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Mode\TemplateResolver\ClassNameTemplateResolver;
use stdClass;

class ClassNameTemplateResolverTest extends TestCase
{
    /**
     * @dataProvider provideResolveFromObject
     */
    public function testResolveFromObject(object $object, string $expected): void
    {
        self::assertEquals($expected, (new ClassNameTemplateResolver())->resolveFor($object));
    }

    /**
     * @return Generator<array>
     */
    public function provideResolveFromObject(): Generator
    {
        yield [
            new stdClass(),
            'stdClass'
        ];

        yield [
            new TestClass(),
            'Phpactor/ObjectRenderer/Tests/Mode/TemplateResolver/TestClass'
        ];
    }
}

class TestClass {}
