<?php

namespace Phpactor\ObjectRenderer\Tests\Mode\TemplateResolver;

use PHPUnit\Framework\TestCase;
use Phpactor\ObjectRenderer\Mode\TemplateResolver\ClassNameTemplateResolver;
use Phpactor\ObjectRenderer\Mode\TemplateResolver\SuffixAppendingTemplateResolver;
use stdClass;

class SuffixAppendingTemplateResolverTest extends TestCase
{
    public function testAppendsSuffix()
    {
        $inner = $this->getMockBuilder(ClassNameTemplateResolver::class)
            ->getMock();
        $inner->expects($this->once())
              ->method('resolveFor')
              ->willReturn('Foobar');

        $resolver = new SuffixAppendingTemplateResolver($inner, '.php.twig');
        self::assertEquals('Foobar.php.twig', $resolver->resolveFor(new stdClass()));
    }

}
