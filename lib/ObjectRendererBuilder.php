<?php

namespace Phpactor\ObjectRenderer;

use Phpactor\ObjectRenderer\Adapter\Twig\TwigObjectRenderer;
use Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor\ObjectRenderer\Model\ObjectRenderer\TolerantObjectRenderer;
use Phpactor\ObjectRenderer\Model\TemplateCandidateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\AncestoralClassTemplateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\ClassNameTemplateProvider;
use Phpactor\ObjectRenderer\Model\TemplateProvider\SuffixAppendingTemplateProvider;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
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

    /**
     * @var bool
     */
    private $renderEmptyOnNotFound = false;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool|string|callable
     */
    private $escaping = false;

    private function __construct()
    {
        $this->logger = new NullLogger();
    }

    /**
     * Create a new instance of the builder.
     * Call build() to create a new ObejctRenderer.
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * When renderEmptyOnNotFound() is set, use this
     * logger to log template not found messages.
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Suffix of the twig files, `.twig` by default
     */
    public function setTemplateSuffix(string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * Add a template path. Can be called multiple times.
     */
    public function addTemplatePath(string $path): self
    {
        $this->templatePaths[] = $path;

        return $this;
    }

    /**
     * Set the Twig escaping strategy:
     *
     * - false: disable auto-escaping
     * - html, js: set the autoescaping to one of the supported strategies
     * - name: set the autoescaping strategy based on the template name extension
     * - PHP callback: a PHP callback that returns an escaping strategy based on the template "name"
     *
     * @param bool|string|callable $escaping
     */
    public function setEscaping($escaping): self
    {
        $this->escaping = $escaping;

        return $this;
    }

    /**
     * Instead of throwing an exception when a template is not found, return
     * empty. If a logger is provided, via. setLogger, log the exception
     * message.
     */
    public function renderEmptyOnNotFound(): self
    {
        $this->renderEmptyOnNotFound = true;

        return $this;
    }

    /**
     * Build the object renderer
     */
    public function build(): ObjectRenderer
    {
        return $this->buildRenderer();
    }

    private function buildRenderer(): ObjectRenderer
    {
        $renderer = new TwigObjectRenderer(
            $this->buildTwig(),
            $this->buildTemplateProvider()
        );

        if ($this->renderEmptyOnNotFound) {
            $renderer = new TolerantObjectRenderer($renderer, $this->logger);
        }

        return $renderer;
    }

    private function buildTwig(): Environment
    {
        return new Environment(
            new FilesystemLoader($this->templatePaths),
            [
                'autoescape' => $this->escaping,
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
