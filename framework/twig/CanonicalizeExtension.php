<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\canonicalizer\Canonicalizer;

class CanonicalizeExtension extends \Twig\Extension\AbstractExtension
{

    public function getFilters(){
        return [
            new \Twig\TwigFilter('canonicalize', [$this, 'canonicalize']),
        ];
    }

    public function canonicalize($value){
        return Canonicalizer::canonicalize($value);
    }

    public function getName(){
        return 'CanonicalizeExtension';
    }
}
