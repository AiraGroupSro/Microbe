<?php

/// unix systems
$root = preg_replace('/^(.*)\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+\/[^\/]+$/','$1',__DIR__);
/// windows
$root = preg_replace('/^(.*)(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+(\\\)[^(\\\)]+$/','$1',$root);
/// make path a directory
$root .= DIRECTORY_SEPARATOR;

require $root.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

/// import autoloader
require_once($root.'src/app/Autoloader.php');

/// set the base directory where your project is located
\Autoloader::setBaseDir($root);

/// add class directories (without the base directory)
\Autoloader::addClassDir([
	'',
]);

$options = array_slice($argv,2);

foreach ($options as $option) {
	if(preg_match('/^--env=/',$option)){
		$env = substr($option,6);
	}
}
if(!isset($env) || strlen($env) <= 0){
	die("ERROR: No environment selected, select with --env=dev|prod|...\n");
}

echo "Initializing parameter enhancer for YAML configuration...\n";
/// initialize parameters enhancer
$parenhancer = new \AiraGroupSro\Microbe\framework\parenhancer\Parenhancer($root.'src/app/config/parameters.'.$env.'.yml');

echo "Initializing dobee...\n";
/// initialize dobee
$dobee = new \AiraGroupSro\Dobee\Dobee(
	$parenhancer->enhance(file_get_contents($root.'src'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'dobee.yml')),
	$root.'src'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'entity',
	'Microbe\\src\\app\\entity'
);
echo "Running the generator...\n\n";
$dobee->generate($options);
echo "> Done!\n";
