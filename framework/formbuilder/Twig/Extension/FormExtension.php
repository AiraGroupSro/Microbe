<?php

namespace AiraGroupSro\Microbe\framework\formbuilder\Twig\Extension;

use AiraGroupSro\Microbe\framework\formbuilder\Factory\FormFactory;
use AiraGroupSro\Microbe\framework\translator\Translator;

class FormExtension extends \Twig\Extension\AbstractExtension
{

    protected $twig;
	protected $translator;

    public function __construct(\Twig\Environment $twig, Translator $translator){
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function getFunctions(){
        $twig = $this->twig;
        $twig->getLoader()->addPath(__DIR__.'/../Template');
        
        return [
            new \Twig\TwigFunction('form',function($form,$path,$attributes = [],$options = []) use ($twig){
                return $twig->render('form.html.twig',[
                    'form' => $form,
                    'path' => $path,
                    'attributes' => $attributes,
                    'options' => $options
                ]);
            },['is_safe' => ['html']]),
            new \Twig\TwigFunction('formAttributes',function($attributes = null) use ($twig){
                $attributesString = '';
                if($attributes !== null){
                    foreach ($attributes as $key => $value) {
                        if(null !== $this->translator){
                            $attributesString .= ' '.$key.'="'.$this->translator->translate($value).'"';
                        }
                        else{
                            $attributesString .= ' '.$key.'="'.$value.'"';
                        }
                    }
                }
                return $attributesString;
            },['is_safe' => ['html']]),
            new \Twig\TwigFunction('formParents',function($formParents,$type = 'name') use ($twig){
                $parentString = '';
                if(count($formParents)){
                    if($type === 'name'){
                        $parentString = '['.implode('][',$formParents).']';
                    }
                    else if($type === 'id'){
                        $parentString = implode('_',$formParents).'_';
                    }
                }
                return $parentString;
            },['is_safe' => ['html']]),
            new \Twig\TwigFunction('formField',function($form,$name,$field,$value,$formParents = []) use ($twig){
                return $twig->render('Theme/'.$field['type'].'.html.twig',[
                    'form' => $form,
                    'name' => $name,
                    'field' => $field,
                    'value' => $value,
                    'formParents' => $formParents,
                ]);
            },['is_safe' => ['html']]),
        ];
    }

    public function getName(){
        return 'FormExtension';
    }
}
