<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\router\Router;

class AssetExtension extends \Twig\Extension\AbstractExtension
{

    protected $router;
    protected $env;
    protected $theme;

    public function __construct(Router $router,$env = 'prod',$theme = 'default'){
        $this->router = $router;
        $this->env = $env;
        $this->theme = $theme;
    }

    public function getFunctions(){
        return [
            new \Twig\TwigFunction('asset',function($assetPath,$absolute = false){
                $path = '';
                if($absolute === true){
                    $path .= $this->router->getRoot();
                }
                else{
                    $path .= $this->router->getBase();
                }

                if($this->env === 'prod' || !preg_match('/^theme\//i',$assetPath)){
                    $path .= '/public/'.$assetPath;
                }
                else{
                    $path .= '/src/themes/'.$this->theme.'/prod/'.preg_replace('/^theme\//i','',$assetPath);
                }

                return $path;
            }),
        ];
    }

    public function getName(){
        return 'AssetExtension';
    }
}
