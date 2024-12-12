<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\router\Router;

class RenderExtension extends \Twig\Extension\AbstractExtension
{

    protected $router;

    public function __construct(Router $router){
        $this->router = $router;
    }

    public function getFunctions(){
        $router = $this->router;
        return [
            new \Twig\TwigFunction('render',function($controller,$action,$options = []) use ($router){
                return $router->render($controller,$action,$options);
            }),
        ];
    }

    public function getName(){
        return 'RenderExtension';
    }
}
