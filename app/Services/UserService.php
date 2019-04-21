<?php

namespace App\Services;

use App\Exceptions\AuthenticationException;
use App\Exceptions\ValidationException;
use App\Http\Responses\BaseResponse;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Validator;

class UserService {

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository ;
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
        return $this->response($this->userRepository->all());
    }

    public function create(array $data) {
        $this->validate($data, array(
            'first_name' => 'required|string|min:1|max:32',
            'last_name' => 'required|string|min:1|max:32',
            'username' => 'required|string|min:6|max:32|unique:users,username'
        ));

        return $this->response($this->userRepository->create($data));
    }

    public function update(array $data) {
        $this->validate($data, array(
            'id' => 'required|integer|exists:users,id',
            'first_name' => 'sometimes|string|min:1|max:32',
            'last_name' => 'sometimes|string|min:1|max:32',
            'username' => 'sometimes|string|min:6|max:32|unique:users,username'
        ));

        $this->userRepository->update($data, $data['id']);

        return $this->response($this->userRepository->show($data['id']));
    }

    public function delete($id) {

        $this->userRepository->delete($id);

        return $this->response();
    }

    public function show($id) {
        $user = $this->userRepository->show($id);

        if (!$user) {
            throw new AuthenticationException('User does not exist');
        }

        return $this->response($user);
    }
}
