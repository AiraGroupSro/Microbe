<?php

namespace AiraGroupSro\Microbe\framework\router\Exception;

use AiraGroupSro\Microbe\framework\router\Exception\AbstractException;

class PageNotFoundException extends AbstractException {
    protected $errorCode = 404;
    protected $message = '404: Page Not Found';
}
