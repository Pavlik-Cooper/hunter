<?php

use Faker\Generator as Faker;

$factory->define(App\Friend::class, function (Faker $faker) {
    return [
        //
        'user_id'=>function(){
            return factory('App\User')->create();
        },
        'friend_id'=> function(){
            return factory('App\User')->create();
        },

    ];
});
