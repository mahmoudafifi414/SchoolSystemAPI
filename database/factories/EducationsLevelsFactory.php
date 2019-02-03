<?php

use Faker\Generator as Faker;

$factory->define(App\EducationalLevel::class, function (Faker $faker) {
    return [
        'name' => $faker->text(30),
    ];
});
