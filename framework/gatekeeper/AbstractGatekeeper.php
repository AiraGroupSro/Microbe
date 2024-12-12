<?php

namespace AiraGroupSro\Microbe\framework\gatekeeper;

abstract class AbstractGatekeeper
{
	protected static $instance;

	public function __construct(){}
	
	public function __wakeup(){}

	public function __clone(){}

	public static function getInstance(){
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}
}
