<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //followsテーブルでは、follower_idとfollowee_idを持ち、「どのユーザーが」「どのユーザーを」フォローしているか管理する
        //onDeleteメソッドで'cascade'を指定し、usersテーブルからレコードが削除された時に、それらに紐づくfollowsテーブルのレコードが同時に削除
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('follower_id');
            $table->foreign('follower_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->bigInteger('followee_id');
            $table->foreign('followee_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
