<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\router\Router;

class RenderExtension extends \Twig_Extension
{

    protected $router;

    public function __construct(Router $router){
        $this->router = $router;
    }

    public function getFunctions(){
        $router = $this->router;
        return [
            new \Twig_SimpleFunction('render',function($controller,$action,$options = []) use ($router){
                return $router->render($controller,$action,$options);
            }),
        ];
    }

    public function getName(){
        return 'RenderExtension';
    }
}
