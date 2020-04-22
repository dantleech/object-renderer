<?php

namespace Phpactor\ObjectRenderer\Mode\TemplateResolver;

use Phpactor\ObjectRenderer\Mode\TemplateResolver;

class ClassNameTemplateResolver implements TemplateResolver
{
    public function resolveFor(object $object): string
    {
        return str_replace('\\', '/', get_class($object));
    }
}
