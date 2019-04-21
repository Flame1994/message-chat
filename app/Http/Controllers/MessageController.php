<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $userService;
    private $messageService;

    public function __construct(UserService $userService, MessageService $messageService) {
        $this->userService = $userService;
        $this->messageService = $messageService;
    }

    public function show($id) {
        return $this->messageService->show($id);
    }

    public function all() {
        return $this->messageService->all();
    }

    public function create(Request $request) {
        return $this->messageService->create($request->input());
    }

    public function update(Request $request) {
        return $this->messageService->update($request->input());
    }

    public function delete($id) {
        return $this->messageService->delete($id);
    }

    public function allMessages($id) {
        return $this->messageService->allMessages($id);
    }

    public function allIncomingMessages($id) {
        return $this->messageService->allIncomingMessages($id);
    }

    public function allOutgoingMessages($id) {
        return $this->messageService->allOutgoingMessages($id);
    }

    public function incomingMessagesFrom($id, $from) {
        return $this->messageService->incomingMessagesFrom($id, $from);
    }

    public function outgoingMessagesTo($id, $to) {
        return $this->messageService->outgoingMessagesTo($id, $to);
    }

    public function messagesBetween($id, $user) {
        return $this->messageService->messagesBetween($id, $user);
    }

}
