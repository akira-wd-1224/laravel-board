<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $name)
    {
        //nameはユニーク制約なのでwhereを使用しても最大１件しか取得できない。
        //whereはコレクションを返すのでfirstを使用し１件分のモデルを取得し$userに代入
        $user = User::where('name', $name)->first();
        //Viewメソッドでブレードを指定し、モデルが入った$userを渡す
        return view('users.show', [
            'user' => $user,
        ]);
    }
}
