<?php

namespace App\Exceptions;

use App\Http\Responses\BaseResponse;
use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected $validationErrors;
    protected $firstError;
    protected $code;

    public function __construct(array $validationErrors, $message = '', $code = 422, Throwable $previous = null)
    {
        $this->validationErrors = $validationErrors;
        $this->message = 'Validation Failed';
        $this->code = $code;
        parent::__construct($message, $code, $previous);
    }

    public function render($request) {
        return new BaseResponse($this->validationErrors, false, $this->code, $this->message);
    }
}
