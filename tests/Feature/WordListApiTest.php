<?php

namespace Tests\Feature;

use App\Word;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class WordListApiTest extends TestCase {

    use RefreshDatabase;

    public function test_should_word一覧を取得する() {
        factory(Word::class, 5)->create();

        $response = $this->json('GET', route('word.index'));

        $response->assertStatus(200);
    }

}
