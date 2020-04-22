<?php

namespace Phpactor\ObjectRenderer\Model\TemplateResolver;

use Phpactor\ObjectRenderer\Model\TemplateResolver;

class SuffixAppendingTemplateResolver implements TemplateResolver
{
    /**
     * @var TemplateResolver
     */
    private $innerResolver;

    /**
     * @var string
     */
    private $suffix;

    public function __construct(TemplateResolver $innerResolver, string $suffix)
    {
        $this->innerResolver = $innerResolver;
        $this->suffix = $suffix;
    }

    public function resolveFor(object $object): string
    {
        return sprintf('%s%s', $this->innerResolver->resolveFor($object), $this->suffix);
    }
}
