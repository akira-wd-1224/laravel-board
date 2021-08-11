<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


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


    public function handleProviderCallback(Request $request, string $provider)
    {
        //Socialite::driver($provider)->stateless()->user()により、Laravel\Socialite\Two\Userというクラスのインスタンスを取得
        //Laravel\Socialite\Two\Userクラスのインスタンスでは、Googleから取得したユーザー情報をプロパティとして持っている。これを変数$providerUser
        $providerUser = Socialite::driver($provider)->stateless()->user();
        //$providerUser->getEmail()により、Googleから取得したユーザー情報からメールアドレスを取得
        //このメールアドレスをwhereメソッドの第二引数に渡し、条件に一致するユーザーモデルをコレクションとして取得
        //$userには、Googleから取得したメールアドレスと同じメールアドレスを持つユーザーモデルが代入される
        //同じメールアドレスを持つユーザーが存在しない場合は、$userにはnullが代入される
        $user = User::where('email', $providerUser->getEmail())->first();
        //$userがnullでなければ、つまりGoogleから取得したメールアドレスと同じメールアドレスを持つユーザーモデルが存在すれば、
        //そのユーザーでログイン処理を行なっている。
        if ($user) {
            //loginメソッドの第二引数をtrueにるが、こうすることでログアウト操作をしない限り、
            //ログイン状態が維持されるようになる。remember meトークンが有効になる
            $this->guard()->login($user, true);
            //ログイン後の画面(記事一覧画面)へ遷移するようにしてる
            //AuthenticatesUsersトレイトのloginメソッド内のコードを参考にした
            return $this->sendLoginResponse($request);
        }
        //$providerUser->tokenでは、Googleから発行されたトークンが返る
        //このトークンがあれば、任意のタイミングでGoogleアカウントのユーザー情報を取得できる
        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token,
        ]);
    }

}

