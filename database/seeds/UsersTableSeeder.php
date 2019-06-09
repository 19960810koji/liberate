<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'name' => 'hoge',
            'email' => 'hoge@example.com',
            'password' => Hash::make('hogehoge'),
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);
    }
}
