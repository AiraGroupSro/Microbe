<?php

namespace AiraGroupSro\Microbe\framework\twig;

class GeneralExtension extends \Twig\Extension\AbstractExtension
{

    public function getFilters(){
        return [
            new \Twig\TwigFilter('intval','intval'),
        ];
    }

    public function getName(){
        return 'GeneralExtension';
    }
}
