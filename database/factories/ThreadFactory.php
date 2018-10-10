<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        //
        'user_id'=>function(){
           return factory('App\User')->create()->id;
        },
        'channel_id'=>function(){
            return factory('App\Channel')->create()->id;
        },
        'title'=> $faker->realText(rand(15, 25)),
        'body'=>$faker->realText(rand(250, 650)),

    ];
});
