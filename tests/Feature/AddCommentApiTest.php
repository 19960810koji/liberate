<?php

namespace Tests\Feature;

use App\User;
use App\Definition;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCommentApiTest extends TestCase {
    
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function test_should_コメントを投稿できる() {
        factory(Definition::class)->create();
        $definition = Definition::first();

        $content = 'test test';

        $response = $this->actingAs($this->user)
            ->json('POST', route('definition.comment', [
                'id' => $definition->id
            ]), compact('content'));

        $comments = $definition->comments()->get();

        $response->assertStatus(201);

        $this->assertEquals(1, $comments->count());
        $this->assertEquals($content, $comments[0]->content);
    }
}
