<?php

namespace AiraGroupSro\Microbe\framework\twig;

use AiraGroupSro\Microbe\framework\translator\Translator;

class TranslateExtension extends \Twig_Extension
{

    protected $translator;

    public function __construct(Translator $translator){
        $this->translator = $translator;
    }

    public function getFilters(){
        return [
            new \Twig_SimpleFilter(
                'translate',
                [
                    $this,
                    'translate'
                ]
            )
        ];
    }

    public function translate($value,$parameters = [],$locale = null){
        return $this->translator->translate($value,$parameters,$locale);
    }

    public function getName(){
        return 'TranslateExtension';
    }
}
