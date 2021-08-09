<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //firstOrCreateメソッドやcreateメソッドを使ってモデルを保存する場合、
    //前提事項としてモデルの$fiilableプロパティにおいて、セットするプロパティ名が記述されている必要がある。
    protected $fillable = [
        'name',
    ];
}
