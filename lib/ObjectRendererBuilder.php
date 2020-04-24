<?php

namespace Phpactor\ObjectRenderer;

use Phpactor\ObjectRenderer\Adapter\Twig\TwigObjectRenderer;
use Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\AncestoralClassTemplateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\ClassNameTemplateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\SuffixAppendingTemplateProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class ObjectRendererBuilder
{
    /**
     * @var array<string>
     */
    private $templatePaths = [];

    /**
     * @var string
     */
    private $suffix = '.twig';

    public static function create(): self
    {
        return new self();
    }

    public function setTemplateSuffix(string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function addTemplatePath(string $path): self
    {
        $this->templatePaths[] = $path;

        return $this;
    }

    public function build(): ObjectRenderer
    {
        return new TwigObjectRenderer($this->buildTwig(), $this->buildTemplateProvider());
    }

    private function buildTwig(): Environment
    {
        return new Environment(
            new FilesystemLoader($this->templatePaths),
            [
                'autoescape' => false,
                'strict_variables' => true,
            ]

        );
    }

    private function buildTemplateProvider(): TemplateCandidateProvider
    {
        return new SuffixAppendingTemplateProvider(
            new AncestoralClassTemplateProvider(
                new ClassNameTemplateProvider()
            ),
            $this->suffix
        );
    }
}
