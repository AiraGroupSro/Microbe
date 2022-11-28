<?php

namespace AiraGroupSro\Microbe\framework\validator\Constraints;

use AiraGroupSro\Microbe\framework\validator\Constraints\ConstraintInterface;

class NotNull implements ConstraintInterface{

	public static function validate($value,$options = null){
		if(null === $value){
			return false;
		}
		return true;
	}

	public static function error($value,$options = null){
		return 'This value must not be null!';
	}

}
