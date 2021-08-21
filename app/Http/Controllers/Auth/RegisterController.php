<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'alpha_num', 'min:3', 'max:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

//    /**
//     * @param Request $request
//     * @param string $provider
//     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    //トークンを使ってGoogleからユーザー情報を再取得
//    public function showProviderUserRegistrationForm(Request $request, string $provider)
//    {
//        //リクエストのパラメータは、Illuminate\Http\Requestクラスのインスタンスである$requestがプロパティとして持っている
//        //LoginContorollerでprovider, email, tokenとパラメータが渡されている
//        //そのため、$request->tokenにより、tokenの値が取得できる。変数$tokenに代入
//        $token = $request->token;
//        //Socialite::driver($provider)->userFromToken($token)により、Laravel\Socialite\Two\Userクラスのインスタンスを取得
//        //userFromTokenメソッドでは、Googleから発行済みのトークンを使って、GoogleのAPIに再度ユーザー情報の問い合わせを行い
//        //その問い合わせにより取得したユーザー情報は、いったん変数$providerUserに代入
//        $providerUser = Socialite::driver($provider)->userFromToken($token);
//        //ユーザー名登録画面のビューの表示
//        //このBladeにはプロバイダー名('google')、Googleから取得したメールアドレス、Googleが発行したトークンを渡す
//        return view('auth.social_register', [
//            'provider' => $provider,
//            'email' => $providerUser->getEmail(),
//            'token' => $token,
//        ]);
//    }

//    /**
//     * @param Request $request
//     * @param string $provider
//     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
//     */
//    public function registerProviderUser(Request $request, string $provider)
//    {
//        //バリデーションの実施
//        $request->validate([
//            'name' => ['required', 'string', 'alpha_num', 'min:3', 'max:16', 'unique:users'],
//            'token' => ['required', 'string'],
//        ]);
//        //リクエストからトークンを取得
//        $token = $request->token;
//        //トークンを使ってGoogleからユーザー情報を再取得
//        $providerUser = Socialite::driver($provider)->userFromToken($token);
//        //ユーザーモデルの作成と保存
//        //createメソッドを使って、ユーザーモデルのインスタンスを作成
//        $user = User::create([
//            'name' => $request->name,//リクエストパラメーターのname
//            'email' => $providerUser->getEmail(),//トークンを使ってGoogleのAPIから取得したユーザー情報のメールアドレス
//            'password' => null,//パスワード登録不要とするので、一律null
//        ]);
//        //RegistersUsersトレイトのregisterメソッド内のコードを参考
//        //登録したユーザー情報で、ログイン済みの状態。第２引数にtrueとしログアウト操作をしない限り、ログイン状態が維持される。
//        $this->guard()->login($user, true);
//        //registeredメソッド内で何か処理が定義してあれば、その結果を返す
//        //registeredメソッド内で何も処理が定義していなければ、redirectPathメソッドで定義されたパス(URL)へリダイレクトする
//        //RegistersUsersトレイトのregisteredメソッドは//と、コメントだけあり、何の処理していない
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
//    }
}
