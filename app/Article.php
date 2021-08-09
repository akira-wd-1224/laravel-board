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
        return $this->BelongsToMany('App\User','likes')->withTimestamps();
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function isLikedBy(?User $user): bool
    {
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
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
