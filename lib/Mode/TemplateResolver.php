<?php

namespace Phpactor\ObjectRenderer\Mode;

interface TemplateResolver
{
    public function resolveFor(object $object): string;
}
