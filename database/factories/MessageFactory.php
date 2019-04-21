<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Message;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;

$factory->define(Message::class, function (Faker $faker) {

    static $users;

    $users = App::runningUnitTests() ? collect([]) : ($users ?: User::limit(100)->get());

    return [
        'from_id' => $users->count() ? $users->random()->id : factory(User::class)->create()->id,
        'to_id' => $users->count() ? $users->random()->id : factory(User::class)->create()->id,
        'text' => $faker->text,
        'read' => mt_rand(0, 1)
    ];
});
