<?php

namespace AiraGroupSro\Microbe\framework\validator\Constraints;

use AiraGroupSro\Microbe\framework\validator\Constraints\ConstraintInterface;

class DateTime implements ConstraintInterface{

	public static function validate($value,$options = null){
		$format = (isset($options['format']) ? $options['format'] : 'Y-m-d H:i:s');
		$dateTime = \DateTime::createFromFormat($format,$value);
		return $dateTime && $dateTime->format($format) === $value;
	}

	public static function error($value,$options = null){
		return $value.' is not a valid date and time!';
	}

}
