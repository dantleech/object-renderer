<?php

namespace Phpactor\ObjectRenderer\Model;

interface TemplateCandidateProvider
{
    /**
     * @return array<string>
     */
    public function resolveFor(object $object): array;
}
