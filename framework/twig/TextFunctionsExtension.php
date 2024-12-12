<?php

namespace AiraGroupSro\Microbe\framework\twig;

class TextFunctionsExtension extends \Twig\Extension\AbstractExtension
{

    public function getFilters(){
        return [
            new \Twig\TwigFilter('ucfirst', [$this, 'utfUcfirst'])
        ];
    }

    public function utfUcfirst($string){
        $first = mb_substr($string,0,1);
        $rest = mb_substr($string,1,mb_strlen($string)-1);
        return mb_strtoupper($first).$rest;
    }

    public function getName(){
        return 'TextFunctionsExtension';
    }
}
