<?php

namespace Phpactor\ObjectRenderer\Tests\Model\TemplateProvider;

use Generator;
use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Model\TemplateProvider\ClassNameTemplateProvider;
use Phpactor\ObjectRenderer\Tests\IntegrationTestCase;
use stdClass;

class AncestoralClassProviderTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideResolveFromObject
     */
    public function testResolveFromObject(string $stub, string $expected): void
    {
        $object = $this->loadStub($stub);
        self::assertEquals($expected, (new AncestoralClassTemplateProvider())->resolveFor($object));
    }

    /**
     * @return Generator<array>
     */
    public function provideResolveFromObject(): Generator
    {
        yield [
            '<?php return new stdClass();',
            'two',
        ];
    }
}

