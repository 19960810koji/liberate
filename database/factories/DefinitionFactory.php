<?php

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Definition::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'word_id' => 1,
        'definition' => $faker->sentence(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
