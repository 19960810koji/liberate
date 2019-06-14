<?php

namespace Tests\Feature;

use App\Word;
use App\Definition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DefinitionListApiTest extends TestCase {
    use RefreshDatabase;

    public function test_should_言葉の定義一覧を取得する() {
        $definitions = factory(Definition::class, 5)->create();
        $response = $this->json('GET', route('definition.index'));

        $response->assertStatus(200);
    }
}