<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;

class ClassNameTemplateProvider implements TemplateCandidateProvider
{
    public function resolveFor(object $object): array
    {
        return [
            str_replace('\\', '/', get_class($object))
        ];
    }
}
