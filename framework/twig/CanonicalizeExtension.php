<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\canonicalizer\Canonicalizer;

class CanonicalizeExtension extends \Twig_Extension
{

    public function getFilters(){
        return [
            new \Twig_SimpleFilter(
                'canonicalize',
                array(
                    $this,
                    'canonicalize'
                )
            )
        ];
    }

    public function canonicalize($value){
        return Canonicalizer::canonicalize($value);
    }

    public function getName(){
        return 'CanonicalizeExtension';
    }
}
