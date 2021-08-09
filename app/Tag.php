<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    //firstOrCreateメソッドやcreateメソッドを使ってモデルを保存する場合、
    //前提事項としてモデルの$fiilableプロパティにおいて、セットするプロパティ名が記述されている必要がある。
    protected $fillable = [
        'name',
    ];

    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }
    public function articles() :BelongsToMany
    {
        return $this->BelongsToMany('App\Article')->withTimestamps();
    }
}
