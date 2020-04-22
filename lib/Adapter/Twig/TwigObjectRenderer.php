<?php

namespace Phpactor\ObjectRenderer\Adapter\Twig;

use Phpactor\ObjectRenderer\Adapter\Twig\Extension\ObjectRendererExtension;
use Phpactor\ObjectRenderer\Mode\TemplateResolver;
use Phpactor\ObjectRenderer\ObjectRenderer;
use Twig\Environment;

class TwigObjectRenderer implements ObjectRenderer
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var TemplateResolver
     */
    private $templateResolver;

    public function __construct(Environment $environment, TemplateResolver $templateResolver)
    {
        $environment->addExtension(new ObjectRendererExtension($this));
        $this->environment = $environment;
        $this->templateResolver = $templateResolver;
    }

    public function render(object $object): string
    {
        return $this->environment->render($this->templateResolver->resolveFor($object), [
            'object' => $object
        ]);
    }
}
