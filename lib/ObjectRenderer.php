<?php

namespace Phpactor\ObjectRenderer;

interface ObjectRenderer
{
    public function render(object $object): string;
}
