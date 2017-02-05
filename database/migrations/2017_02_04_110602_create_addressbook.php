<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_books', function (Blueprint $table) {
            $table->increments('id');
            // 種類
            $table->integer('type');
            // 個人電話帳の場合の所有者ID
            $table->integer('owner_userid');
            // グループID
            $table->integer('groupid');
            // 役職
            $table->string('position');
            // フリガナ
            $table->string('name_kana');
            // 名前
            $table->string('name');
            // 電話番号1
            $table->string('tel1');
            $table->string('tel2');
            $table->string('tel3');
            // メールアドレス
            $table->string('email');
            // 備考
            $table->string('comment');
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
        Schema::drop('addressbooks');
    }
}
