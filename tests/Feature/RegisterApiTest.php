<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterApiTest extends TestCase {
    use RefreshDatabase;

    public function test_should_新しいユーザーを作成して返却する() {
        $data = [
            'name'                  => 'hoge',
            'email'                 => 'hoge@example.com',
            'password'              => 'hogehoge',
            'password_confirmation' => 'hogehoge'
        ];
        $response = $this->json('POST', route('register'), $data);

        $user = User::first();
        $this->assertEquals($data['name'], $user->name);

        $response
            ->assertStatus(201)
            ->assertJson(['name' => $user->name]);
    }

}
