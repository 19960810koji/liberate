<?php

namespace Tests\Feature;

use App\User;
use App\Definition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPageApiTest extends TestCase {
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function test_should_正しいJSONを返す() {
        $definition = factory(Definition::class, 3)->create();

        $response = $this->json('GET', route('user.index', [
            'id' => $this->user->id,
        ]));

        $response->assertStatus(200);
    }
}
