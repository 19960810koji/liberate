<?php

namespace Tests\Feature;

use App\User;
use App\Definition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeApiTest extends TestCase {

    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Definition::class)->create();
        $this->definition = Definition::first();
    }

    public function test_should_いいねを追加できる() {
        $response = $this->actingAs($this->user)
            ->json('PUT', route('definition.like', [
                'definition' =>$this->definition->id
            ]));

        $response->assertStatus(200);

        $this->assertEquals(1, $this->definition->likes()->count());
    }

    public function test_should_2つ以上いいねが付かない() {
        $param = ['id' => $this->definition->id];

        $this->actingAs($this->user)->json('PUT', route('definition.like', $param));
        $this->actingAs($this->user)->json('PUT', route('definition.like', $param));

        $this->assertEquals(1, $this->definition->likes()->count());
    }

    public function test_should_いいねを解除できる() {
        $this->definition->likes()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->json('DELETE', route('definition.like', [
                'definition' => $this->definition->id,
            ]));

        $response->assertStatus(200);

        $this->assertEquals(0, $this->definition->likes()->count());
    }

    
}
