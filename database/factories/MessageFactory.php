<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Message;
use App\User;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    static $users;

    $users = App::runningUnitTests() ? collect([]) : ($users ?: User::limit(250)->get());

    return [
        'from_id' => $users->count() ? $users->random()->id : $faker->unique()->numberBetween(1, 250),
        'to_id' => $users->count() ? $users->random()->id : $faker->unique()->numberBetween(1, 250),
        'text' => $faker->text,
        'read' => mt_rand(0, 1)
    ];
});
