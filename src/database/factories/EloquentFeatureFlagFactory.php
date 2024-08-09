<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;

$factory->define(EloquentFeatureFlag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'enabled' => $faker->boolean,
        'audience' => json_encode([]),
        'percentage' => $faker->numberBetween(0, 100),
        'finish_date' => $faker->dateTimeBetween('-1 month', '+1 month'),
    ];
});
