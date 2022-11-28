<?php

namespace AiraGroupSro\Microbe\framework\router\Exception;

use AiraGroupSro\Microbe\framework\router\Exception\AbstractException;

class UnauthorizedException extends AbstractException {
	protected $errorCode = 401;
	protected $message = '401: Unauthorized';
}
