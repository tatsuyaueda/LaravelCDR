<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->truncate();
		
		DB::table('users')->insert([
			'name' => '管理者',
			'email' => 'admin@example.com',
			'password' => bcrypt('admin'),
		]);
	}

}
