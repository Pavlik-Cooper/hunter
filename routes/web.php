<?php

Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }

    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
        array_splice($segments, 1, 0, $lang);
    }

    //формируем полный URL
    $url = Request::root().implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');


Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){

    Route::get('/','ThreadsController@index')->name('threads');
    Auth::routes();
    Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
    Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
    Route::delete('/profiles/{user}/notifications/{notification?}', 'UserNotificationsController@destroy');

    Route::get('/channels/create', 'ChannelsController@create')->middleware('email-must-be-confirmed');

    Route::get('/threads/create', 'ThreadsController@create')->middleware('email-must-be-confirmed');

    Route::post('/threads/store', 'ThreadsController@store')->middleware('email-must-be-confirmed');
    Route::post('/channels/store', 'ChannelsController@store')->middleware('email-must-be-confirmed');

    Route::get('/threads/{channel}', 'ThreadsController@index')->name('channel.show');
    Route::get('/threads/{channel}/{thread}/', 'ThreadsController@show');
    Route::put('/threads/{channel}/{thread}/', 'ThreadsController@update');
    Route::delete('/threads/{channel}/{thread}/', 'ThreadsController@destroy');
    Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
    Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

    Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
    Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
    Route::delete('/replies/{reply}', 'RepliesController@destroy');
    Route::patch('/replies/{reply}', 'RepliesController@update');

    Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
    Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
    Route::get('/register/confirm','RegisterConfirmationController@index');
    Route::post('/api/users/{user}/avatar','Api\UserAvatarController@store')->middleware('auth');

    Route::get('/api/chat/{user}/friends','Api\FriendsController@index')->middleware('auth');
    Route::post('/api/chat/{user}/friends','Api\FriendsController@store')->middleware('auth');
    Route::delete('/api/chat/{user}/friends','Api\FriendsController@destroy')->middleware('auth');

    Route::post('/api/chat/session/create','Chat\SessionController@store')->middleware('auth');
    Route::post('/api/chat/{session}/message','Chat\ChatController@store')->middleware('auth');
    Route::get('/api/chat/{session}/read','Chat\ChatController@markAsRead')->middleware('auth');
    Route::get('/api/chat/{session}/chats','Chat\ChatController@index')->middleware('auth');
    Route::delete('/api/chat/{session}/clear','Chat\ChatController@clear')->middleware('auth');
    Route::post('/api/chat/{session}/block','Chat\ChatController@block')->middleware('auth');
    Route::post('/api/chat/{session}/unblock','Chat\ChatController@unblock')->middleware('auth');

});


