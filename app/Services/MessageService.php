<?php

namespace App\Services;

use App\Exceptions\AuthenticationException;
use App\Exceptions\ValidationException;
use App\Http\Responses\BaseResponse;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use Validator;

class MessageService {

    protected $messageRepository;
    protected $userRepository;
    public function __construct(MessageRepository $messageRepository, UserRepository $userRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    public function response($data = null) {
        return new BaseResponse($data);
    }

    public function validate($data, $validationRules) {
        $validator = Validator::make($data, $validationRules);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages()->toArray());
        }
    }

    public function all() {
        return $this->response($this->messageRepository->all());
    }

    public function create(array $data) {
        $this->validate($data, array(
            'from_id' => 'required|integer|exists:users,id',
            'to_id' => 'required|integer|exists:users,id',
            'text' => 'required|string|min:1|max:1024',
        ));
        $data['read'] = 0;

        return $this->response($this->messageRepository->create($data));
    }

    public function update(array $data) {
        $this->validate($data, array(
            'id' => 'required|integer|exists:messages,id',
            'from_id' => 'required|integer|exists:users,id',
            'text' => 'sometimes|string|min:1|max:1024',
            'read' => 'sometimes|integer|in:1'
        ));

        $record = $this->messageRepository->show($data['id']);
        if ($record->from_id != $data['from_id']) {
            throw new AuthenticationException('User can\'t update this message');
        }

        return $this->response($this->messageRepository->update($data, $data['id']));
    }

    public function delete($id) {

        $message = $this->messageRepository->show($id);

        if (!$message) {
            throw new AuthenticationException('Message does not exist');
        }

        $this->messageRepository->delete($id);

        return $this->response();
    }

    public function show($id) {
        $user = $this->messageRepository->show($id);

        if (!$user) {
            throw new AuthenticationException('Message does not exist');
        }

        return $this->response($user);
    }

    public function allMessages($id) {
        return $this->response($this->messageRepository->allMessages($id));
    }

    public function allIncomingMessages($id) {
        return $this->response($this->messageRepository->allIncomingMessages($id));
    }

    public function allOutgoingMessages($id) {
        return $this->response($this->messageRepository->allOutgoingMessages($id));
    }

    public function incomingMessagesFrom($id, $from) {
        return $this->response([
            'users' => $this->userRepository->showMany([$id, $from]),
            'messages' => $this->messageRepository->incomingMessagesFrom($id, $from)
        ]);
    }

    public function outgoingMessagesTo($id, $to) {
        return $this->response([
            'users' => $this->userRepository->showMany([$id, $to]),
            'messages' => $this->messageRepository->outgoingMessagesTo($id, $to)
        ]);
    }

    public function messagesBetween($id, $user) {
        return $this->response([
            'users' => $this->userRepository->showMany([$id, $user]),
            'messages' => $this->messageRepository->messagesBetween($id, $user)
        ]);
    }


}
