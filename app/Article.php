<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'body',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo('App\User');
    }

    /**
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        //リレーション元/先のテーブル名の単数形_idという規則性があれば第三引数と第四引数は省略可能
        return $this->BelongsToMany('App\User','likes')->withTimestamps();
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function isLikedBy(?User $user): bool
    {
//動的プロパティlikesを使用することで、Articleモデルから
//likesテーブル経由で紐付くUserモデルが、コレクション(配列を拡張したもの)で返る
        return $user
            ?(bool)$this->likes->where( 'id', $user->id)->count()
            : false;
    }

    /**
     * @return int
     */
    public function getCountLikesAttribute(): int//get...Attributeアクセサとなる
    {
        //アクセサとして定義することで$article->count_likesのようにスネークケースで呼び出し可になる
        //likesの要素の数を返す。likesのモデルのインスタンスでBelongsToManyクラスのインスタンスではない。
        return $this->likes->count();
    }
    public function tags(): BelongsToMany
    {
        //article_tagといった2つのモデル名の単数形をアルファベット順に結合した名前なので、第二引数は省略可
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
