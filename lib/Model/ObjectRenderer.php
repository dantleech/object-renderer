<?php

namespace Phpactor\ObjectRenderer\Model;

interface ObjectRenderer
{
    /**
     * @param array<mixed> $args
     */
    public function render(object $object, array $args = []): string;
}
