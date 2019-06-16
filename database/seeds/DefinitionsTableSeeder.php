<?php

use Illuminate\Database\Seeder;

class DefinitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('definitions')->insert([
            'user_id' => 1,
            'word_id' => 1,
            'definition' => '幸せでーす。',
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);

        DB::table('definitions')->insert([
            'user_id' => 1,
            'word_id' => 2,
            'definition' => 'お金は大事！',
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);

        DB::table('definitions')->insert([
            'user_id' => 1,
            'word_id' => 3,
            'definition' => '人生はいろいろ、男もいろいろ',
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);

        DB::table('definitions')->insert([
            'user_id' => 2,
            'word_id' => 1,
            'definition' => 'ただの紙切れでしょ',
            "created_at" => new DateTime(),
            "updated_at" => new DateTime()
        ]);

    }
}
