<?php

namespace Phpactor\ObjectRenderer\Model\TemplateResolver;

use Phpactor\ObjectRenderer\Model\TemplateResolver;

class ClassNameTemplateResolver implements TemplateResolver
{
    public function resolveFor(object $object): string
    {
        return str_replace('\\', '/', get_class($object));
    }
}
