<?php

namespace Phpactor\ObjectRenderer\Model\TemplateProvider;

use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;

class AncestoralClassTemplateProvider implements TemplateCandidateProvider
{
    /**
     * {@inheritDoc}
     */
    public function resolveFor(object $object): string
    {
        return '';
    }
}
