<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressBookGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_book_groups', function (Blueprint $table) {
            $table->increments('id');
            // 親グループ番号
            $table->integer('parent_groupid');
            // 種類
            $table->integer('type');
            // 個人電話帳の場合の所有者ID
            $table->integer('owner_userid');
            // グループ名
            $table->string('group_name');
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
        Schema::drop('address_book_groups');
    }
}
