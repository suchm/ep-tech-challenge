<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'date' => Carbon::make($faker->dateTimeBetween('-1 year', 'now')),
        'body' => $faker->paragraphs(1, true),
    ];
});
