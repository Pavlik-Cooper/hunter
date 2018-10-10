<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        $userSocial = Socialite::driver($service)->stateless()->user();
        $user = User::where('email',$userSocial->email)->first();
        if ($user){
            $user->confirmed = true;
            $user->confirmation_token = null;
            $user->save();
            Auth::login($user);
        }else {
//            dd($userSocial);
            $user = new User;
            $user->email = $userSocial->email;
            $user->confirmed = true;
            $user->name = !is_null($userSocial->name) ? $userSocial->name : $userSocial->email;
            $user->avatar = !is_null($userSocial->avatar) ? $userSocial->avatar : null;

            $user->save();
            Auth::login($user);
        }

        return redirect('/')->with(['flash'=>['type'=>'s','message'=> trans('You logged in as ') .$user->name]]);
    }
}
