<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function show($id) {
        return $this->userService->show($id);
    }

    public function all() {
        return $this->userService->all();
    }

    public function create(Request $request) {
        return $this->userService->create($request->input());
    }

    public function update(Request $request) {
        return $this->userService->update($request->input());
    }

    public function delete($id) {
        return $this->userService->delete($id);
    }
}
