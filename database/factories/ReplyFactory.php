<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        //
        'body'=>$faker->realText(rand(20, 35)),
        'user_id'=>function(){
            return factory('App\User')->create()->id;
        },
        'thread_id'=>function(){
            return factory('App\Thread')->create()->id;
        }
    ];
});
