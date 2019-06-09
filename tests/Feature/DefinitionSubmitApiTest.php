<?php

namespace Tests\Feature;

use App\User;
use App\Definition;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DefinitionSubmitApiTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function test_should_言葉の定義を投稿する() {
        $data = [
            'word_id' => 2,
            'definition' => "テストです。",
        ];

        $response = $this->actingAs($this->user)
            ->json('POST', route('definition.create'), $data);

        $definition = Definition::first();
        $this->assertEquals($data['definition'], $definition->definition);

        $response
            ->assertStatus(201)
            ->assertJson(['definition' => $definition->definition]);
    }
}
