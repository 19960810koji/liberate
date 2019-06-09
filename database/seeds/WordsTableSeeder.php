<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $words = ['幸せ', 'お金', '人生'];
        foreach($words as $word) {
            DB::table('words')->insert([
                'word' => $word,
                "created_at" => new DateTime(),
                "updated_at" => new DateTime()
            ]);
        }
    }
}
