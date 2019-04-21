<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class BaseResponse implements  Responsable {

    private $success;
    private $code;
    private $msg;
    private $data;

    public function __construct($data = null, $success = true, $code = 200, $msg = '') {
        $this->success = $success;
        $this->code = $code;
        $this->msg = $msg;
        $this->data = $data;
    }

    public function toResponse($request)
    {
        return response()->json([
           'success' => $this->success,
           'code' => $this->code,
           'msg' => $this->msg,
           'data' => $this->data
        ]);
    }
}
