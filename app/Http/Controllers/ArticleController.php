<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        $articles =(object)[

            (object)[
                'id' => 1,
                'title' => 'タイトル',
                'body' => 'ボディ',
                'created_at' => now(),
                'user' => (object)[
                    'id' => 1,
                    'name' => 'ユーザー名１'
                ]
            ],

            (object)[
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'ボディ',
                'created_at' => now(),
                'user' => (object)[
                    'id' => 2,
                    'name' => 'ユーザー名２'
                ]
            ],

            (object)[
                'id' => 3,
                'title' => 'タイトル',
                'body' => 'ボディ',
                'created_at' => now(),
                'user' => (object)[
                    'id' => 3,
                    'name' => 'ユーザー名３'
                ]
            ],
        ];
        return view('articles.index',['articles'=>$articles]);
    }
}
