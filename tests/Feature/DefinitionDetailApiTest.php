<?php

namespace Tests\Feature;

use App\Definition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DefinitionDetailApiTest extends TestCase {

    use RefreshDatabase;

    public function test_should_正しい構造のJSONを返却する() {
        factory(Definition::class)->create();
        $definition = Definition::first();

        $response = $this->json('GET', route('definition.detail', [
            'id' => $definition->id,
        ]));

        $response->assertStatus(200);
    }
}
