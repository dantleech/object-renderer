<?php

namespace Phpactor\ObjectRenderer\Adapter\Twig\Extension;

use Phpactor\ObjectRenderer\ObjectRenderer;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class ObjectRendererExtension extends AbstractExtension
{
    /**
     * @var ObjectRenderer
     */
    private $renderer;

    public function __construct(ObjectRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('render', function (object $object) {
                return $this->renderer->render($object);
            })
        ];
    }
}
