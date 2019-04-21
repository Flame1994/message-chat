<?php

namespace Tests\Feature;

use App\Message;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class MessageTest extends TestCase
{
    use WithFaker, DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateValidMessage()
    {
        $from = factory(User::class)->create();
        $to = factory(User::class)->create();
        $data = [
            'from_id' => $from->id,
            'to_id' => $to->id,
            'text' => $this->faker->text
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'from_id' => $data['from_id'],
                    'to_id' => $data['to_id'],
                    'text' => $data['text'],
                    'read' => 0
                ]
            ]);
    }

    public function testCreateInvalidMessage()
    {
        $data = [];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 422,
                'data' => [
                    'from_id' => [
                        'The from id field is required.'
                    ],
                    'to_id' => [
                        'The to id field is required.'
                    ],
                    'text' => [
                        'The text field is required.'
                    ]
                ]
            ]);
    }

    public function testGetAllMessages() {
        $response = $this->json('GET', '/api/messages');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200
            ]);
    }

    public function testGetValidMessage() {
        $message = factory(Message::class)->create();
        $response = $this->json('GET', '/api/messages/' . $message->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'id' => $message->id,
                    'from_id' => $message->from_id,
                    'to_id' => $message->to_id,
                    'text' => $message->text,
                    'read' => $message->read,
                ]
            ]);
    }

    public function testGetInvalidMessage() {
        $response = $this->json('GET', '/api/messages/0');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 401,
                'msg' => 'Message does not exist'
            ]);
    }

    public function testUpdateValidMessage() {
        $message = factory(Message::class)->create();
        $data = [
            'id' => $message->id,
            'from_id' => $message->from_id,
            'text' => $this->faker->text,
            'read' => 1
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'id' => $message->id,
                    'from_id' => $message->from_id,
                    'text' => $data['text'],
                    'read' => $data['read'],
                    'to_id' => $message->to_id
                ]
            ]);
    }

    public function testUpdateInvalidMessage() {
        $data = [];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 422,
                'data' => [
                    'id' => [
                        'The id field is required.',
                    ],
                    'from_id' => [
                        'The from id field is required.'
                    ]
                ]
            ]);
    }

    public function testUpdateInvalidMessageTextRead() {
        $message = factory(Message::class)->create();
        $data = [
            'id' => $message->id,
            'from_id' => $message->from_id,
            'read' => 0
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 422,
                'data' => [
                    'read' => [
                        'The selected read is invalid.'
                    ]
                ]
            ]);
    }

    public function testUpdateInvalidMessageFrom() {
        $message = factory(Message::class)->create();
        $data = [
            'id' => $message->id,
            'from_id' => ($message->from_id + 1),
            'text' => $this->faker->text
        ];

        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('PUT', '/api/messages', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 401,
                'msg' => 'User can\'t update this message'
            ]);
    }

    public function testDeleteMessage() {
        $message = factory(Message::class)->create();

        $response = $this->json('DELETE', '/api/messages/' . $message->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200
            ]);
    }

    public function testDeleteInvalidMessage() {
        $response = $this->json('DELETE', '/api/messages/0');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false,
                'code' => 401,
                'msg' => 'Message does not exist'
            ]);
    }

    public function testGetUserMessages() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();

        $message1 = [
            'from_id' => $user->id,
            'to_id' => $user2->id,
            'text' => $this->faker->text
        ];
        $message2 = [
            'from_id' => $user2->id,
            'to_id' => $user->id,
            'text' => $this->faker->text
        ];
        $message3 = [
            'from_id' => $user3->id,
            'to_id' => $user->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message1);
        $this->createMessage($message2);
        $this->createMessage($message3);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    [
                        'from_id' => $message1['from_id'],
                        'to_id' => $message1['to_id'],
                        'text' => $message1['text'],
                    ],
                    [
                        'from_id' => $message2['from_id'],
                        'to_id' => $message2['to_id'],
                        'text' => $message2['text'],
                    ],
                    [
                        'from_id' => $message3['from_id'],
                        'to_id' => $message3['to_id'],
                        'text' => $message3['text'],
                    ]

                ]
            ]);

    }

    public function testGetNoUserMessages() {
        $response = $this->json('GET', '/api/users/0/messages');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => []
            ]);
    }

    public function testGetUserIncomingMessages() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message = [
            'from_id' => $user2->id,
            'to_id' => $user->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages/inc');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    [
                        'from_id' => $message['from_id'],
                        'to_id' => $message['to_id'],
                        'text' => $message['text'],
                    ]
                ]
            ]);
    }

    public function testGetUserIncomingMessagesFromUser() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message = [
            'from_id' => $user2->id,
            'to_id' => $user->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages/inc/' . $user2->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'messages' => [
                        [
                            'from_id' => $message['from_id'],
                            'to_id' => $message['to_id'],
                            'text' => $message['text'],
                        ]
                    ]
                ]
            ]);
    }

    public function testGetUserOutgoingMessages() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message = [
            'from_id' => $user->id,
            'to_id' => $user2->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages/out');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    [
                        'from_id' => $message['from_id'],
                        'to_id' => $message['to_id'],
                        'text' => $message['text'],
                    ]
                ]
            ]);
    }

    public function testGetUserOutgoingMessagesToUser() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message = [
            'from_id' => $user->id,
            'to_id' => $user2->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages/out/' . $user2->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'messages' => [
                        [
                            'from_id' => $message['from_id'],
                            'to_id' => $message['to_id'],
                            'text' => $message['text'],
                        ]
                    ]
                ]
            ]);
    }

    public function testGetUserMessagesBetweenUser() {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $message1 = [
            'from_id' => $user->id,
            'to_id' => $user2->id,
            'text' => $this->faker->text
        ];
        $message2 = [
            'from_id' => $user2->id,
            'to_id' => $user->id,
            'text' => $this->faker->text
        ];

        $this->createMessage($message1);
        $this->createMessage($message2);

        $response = $this->json('GET', '/api/users/'. $user->id . '/messages/all/' . $user2->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 200,
                'data' => [
                    'messages' => [
                        [
                            'from_id' => $message1['from_id'],
                            'to_id' => $message1['to_id'],
                            'text' => $message1['text'],
                        ],
                        [
                            'from_id' => $message2['from_id'],
                            'to_id' => $message2['to_id'],
                            'text' => $message2['text'],
                        ]
                    ]
                ]
            ]);
    }

    public function createMessage($message) {
        $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->json('POST', '/api/messages', $message);
    }
}
