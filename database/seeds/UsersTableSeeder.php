<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //DB::table('roles')->truncate();

        $admin = new \App\Role();
        $admin->name = 'admin';
        $admin->display_name = '管理者';
        $admin->save();

        $operator = new \App\Role();
        $operator->name = 'operator';
        $operator->display_name = '担当者';
        $operator->save();

        //DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => '管理者',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);

        $user = \App\User::where('username','=','admin')->first();
        $user->attachRole( $admin);

    }

}
