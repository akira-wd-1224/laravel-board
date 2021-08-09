<?php

namespace App;

use App\Mail\BareMail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        //カスタマイズしたテキストメールがパスワード再設定メールとして送信される
        //作成した通知クラスである、PasswordResetNotificationクラスのインスタンスを生成し、notifyメソッドに渡す。
        $this->notify(new PasswordResetNotification($token, new BareMail()));
    }

    public function followers(): BelongsToMany
    {
        //belongsToManyメソッドの第三引数と第四引数は省略せずに記述。リレーション元/先のテーブル名の単数形_idという規則性がないため。
        //リレーション元のusersテーブルのidは、中間テーブルのfollowee_idと紐付く
        //リレーション先のusersテーブルのidは、中間テーブルのfollower_idと紐付く
        //中間テーブルのカラム名と、リレーション元/先のテーブル名に前述の規則性がない
        return $this->belongsToMany('App\User', 'follows', 'followee_id', 'follower_id')
            ->withTimestamps();
    }

    public function isFollowedBy(?User $user): bool
    {
        //$this->followersでfollowers経由のuserコレクションを返す
        return $user
            ? (bool)$this->followers->where('id', $user->id)->count()
            : false;

    }
}
