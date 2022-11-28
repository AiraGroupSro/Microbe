<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\router\Router;

class PathExtension extends \Twig_Extension
{

    protected $router;

    public function __construct(Router $router){
        $this->router = $router;
    }

    public function getFunctions(){
        $router = $this->router;
        return [
            new \Twig_SimpleFunction('path',function($pathName,$options = [],$absolute = false) use ($router){
                return $router->path($pathName,$options,$absolute);
            }),
        ];
    }

    public function getName(){
        return 'PathExtension';
    }
}
