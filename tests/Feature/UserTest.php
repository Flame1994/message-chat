<?php

namespace Tests\Feature;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function testCreateValidUser()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/users', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'username' => $data['username'],
                ]
            ]);
    }

    public function testCreateInvalidUser()
    {
        $data = [];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/users', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 422,
                'data' => [
                    'username' => [
                        'The username field is required.'
                    ],
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'last_name' => [
                        'The last name field is required.'
                    ]
                ]
            ]);
    }

    public function testGetAllUsers() {
        $response = $this->json('GET', '/api/users');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200
            ]);
    }

    public function testGetValidUser() {
        $user = factory(User::class)->create();
        $response = $this->json('GET', '/api/users/' . $user->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                ]
            ]);
    }

    public function testGetInvalidUser() {
        $response = $this->json('GET', '/api/users/0');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 401,
                'msg' => 'User does not exist'
            ]);
    }

    public function testUpdateValidUser() {
        $user = factory(User::class)->create();
        $data = [
            'id' => $user->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/users', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'id' => $user->id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'username' => $data['username']
                ]
            ]);
    }

    public function testUpdateInvalidUser() {
        $user = factory(User::class)->create();
        $data = [
            'id' => $user->id,
            'username' => $user->username
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/users', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 422,
                'data' => [
                    'username' => [
                        'The username has already been taken.'
                    ],
                ]
            ]);
    }

    public function testDeleteUser() {
        $user = factory(User::class)->create();

        $response = $this->json('DELETE', '/api/users/' . $user->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200
            ]);
    }

    public function testDeleteInvalidUser() {
        $response = $this->json('DELETE', '/api/users/0');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 401,
                'msg' => 'User does not exist'
            ]);
    }
}
