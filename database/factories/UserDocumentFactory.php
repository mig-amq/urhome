<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\UserDocument;
use Faker\Generator as Faker;

$factory->define(UserDocument::class, function (Faker $faker) {
    return [
        "Images" => "[" . $faker->imageUrl() . "]",
        "Files" => "[http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.105.3184&rep=rep1&type=pdf]",
        "UserID" => rand(1, 10)
    ];
});
