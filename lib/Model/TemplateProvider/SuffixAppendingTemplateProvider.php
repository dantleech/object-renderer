<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;

class SuffixAppendingTemplateProvider implements TemplateCandidateProvider
{
    /**
     * @var TemplateResolver
     */
    private $innerResolver;

    /**
     * @var string
     */
    private $suffix;

    public function __construct(TemplateCandidateProvider $innerResolver, string $suffix)
    {
        $this->innerResolver = $innerResolver;
        $this->suffix = $suffix;
    }

    public function resolveFor(object $object): string
    {
        return sprintf('%s%s', $this->innerResolver->resolveFor($object), $this->suffix);
    }
}
