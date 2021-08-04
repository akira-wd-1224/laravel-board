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
            ],

            (object)[
                'id' => 2,
                'title' => 'タイトル',
                'body' => 'ボディ',
            ],

            (object)[
                'id' => 3,
                'title' => 'タイトル',
                'body' => 'ボディ',
            ],
        ];
        return view('articles.index',['articles'=>$articles]);
    }
}
