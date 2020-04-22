<?php

namespace Phpactor\ObjectRenderer\Model;

interface TemplateResolver
{
    public function resolveFor(object $object): string;
}
