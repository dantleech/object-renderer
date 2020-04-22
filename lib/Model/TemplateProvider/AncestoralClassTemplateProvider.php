<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use ReflectionClass;

class AncestoralClassTemplateProvider implements TemplateCandidateProvider
{
    /**
     * @var TemplateCandidateProvider
     */
    private $innerProvider;

    public function __construct(TemplateCandidateProvider $innerProvider)
    {
        $this->innerProvider = $innerProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function resolveFor(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $list = [$reflection];
        while (false !== $reflection = $reflection->getParentClass()) {
            $list[] = $reflection;
        }

        return array_map(function (ReflectionClass
    }
}
