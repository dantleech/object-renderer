<?php

namespace Phpactor\ObjectRenderer\Adapter\Twig;

use Phpactor\ObjectRenderer\Adapter\Twig\Extension\ObjectRendererExtension;
use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor\ObjectRenderer\Model\TemplateResolver;
use Twig\Environment;
use Twig\Error\LoaderError;

class TwigObjectRenderer implements ObjectRenderer
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var TemplateCandidateProvider
     */
    private $templateProvider;

    public function __construct(Environment $environment, TemplateCandidateProvider $templateProvider)
    {
        $environment->addExtension(new ObjectRendererExtension($this));
        $this->environment = $environment;
        $this->templateProvider = $templateProvider;
    }

    public function render(object $object): string
    {
        foreach ($this->templateProvider->resolveFor(get_class($object)) as $template) {
            try {
                return $this->environment->render(
                    $template,
                    ['object' => $object]
                );
            } catch (LoaderError $error) {
                continue;
            }
        }

        return '';
    }
}
