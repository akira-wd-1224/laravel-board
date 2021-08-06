<?php

namespace App\Notifications;

use App\Mail\BareMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//独自のパスワード再設定メールを送信するための通知クラス
class PasswordResetNotification extends Notification
{
    use Queueable;

    public $token;
    public $mail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    //クラスのインスタンスをコンストラクタにて注入(DI)する
    public function __construct(string $token, BareMail $mail)
    {
        $this->token = $token;
        $this->mail = $mail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BareMail
     */
    public function toMail($notifiable)
    {
        return $this->mail
            //第一引数には送信元メールアドレス,第二引数にはメールの送信者名(省略可)。それぞれconfig()の値を使用している
            ->from(config('mail.from.address'),config('mail.from.name'))
            //送信先メールアドレスを渡す。$notifiableには、パスワード再設定メール送信先となるUserモデルが代入されている。
            ->to($notifiable->email)
            //メールの件名を渡す
            ->subject('[Board]パスワード再設定')
            //キスト形式のメールを送る場合に使うメソッド。引数で、メールのテンプレートを指定。
            ->text('emails.password_reset')
            //テンプレートとなるBladeに渡す変数を、withメソッドに連想配列形式で渡す。
            ->with([
                //route関数を使ってpassword.resetのルーティングをセット
                //emailは、クエリストリング(Query String)としてURLに付加
                'url' => route('password.reset',['token' => $this->token, 'email' => $notifiable->email,]),
                //キーcountの値には、パスワード設定画面へのURLの有効期限(単位は分)をセット
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'expire'),
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
