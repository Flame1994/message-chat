<?php

namespace App\Exceptions;

use App\Http\Responses\BaseResponse;
use Exception;
use Throwable;

class AuthenticationException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "", $code = 401, Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message, $code, $previous);
    }

    public function render($request) {
        return new BaseResponse(null, false, $this->code, $this->message);
    }
}
