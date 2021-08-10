<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param string $provider
     * @return mixed
     */
    //Socialiteのdirverメソッドに、外部のサービス名を渡す
    //つまり、
    //「Googleでログインボタン」を押す
    //localhost/login/googleにアクセスする(GETリクエストする)
    //redirectToProviderアクションメソッドが実行される
    //Googleのアカウント選択画面へリダイレクトされる
    //という流れ
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }
}
