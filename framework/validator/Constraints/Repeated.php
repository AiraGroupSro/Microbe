<?php

namespace AiraGroupSro\Microbe\framework\validator\Constraints;

use AiraGroupSro\Microbe\framework\validator\Constraints\ConstraintInterface;

class Repeated implements ConstraintInterface{

	public static function validate($value,$options = null){
		if($value['password'] !== $value['repeated']){
			return false;
		}
		return true;
	}

	public static function error($value,$options = null){
		return 'Passwords must match!';
	}

}
