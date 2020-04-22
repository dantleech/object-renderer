<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;

class ClassNameTemplateProvider implements TemplateCandidateProvider
{
    public function resolveFor(object $object): string
    {
        return str_replace('\\', '/', get_class($object));
    }
}
