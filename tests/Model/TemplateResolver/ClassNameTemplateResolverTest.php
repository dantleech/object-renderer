<?php

namespace Phpactor\ObjectRenderer\Tests\Model\TemplateResolver;

use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Model\TemplateResolver\ClassNameTemplateResolver;
use Phpactor\ObjectRenderer\Tests\IntegrationTestCase;
use stdClass;

class ClassNameTemplateResolverTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideResolveFromObject
     */
    public function testResolveFromObject(string $stub, string $expected): void
    {
        $object = $this->loadStub($stub);
        self::assertEquals($expected, (new ClassNameTemplateResolver())->resolveFor($object));
    }

    /**
     * @return Generator<array>
     */
    public function provideResolveFromObject(): Generator
    {
        yield [
            'SingleObject.php.stub',
            'stdClass'
        ];

        yield [
            'NamespacedObject.php.stub',
            'Test/Object/TestObject'
        ];
    }
}

class TestClass {}
