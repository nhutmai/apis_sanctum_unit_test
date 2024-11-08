<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
//    use RefreshDatabase;
    use DatabaseTransactions;

    public function test_user_can_register_successfully()
    {
        $user=[
            'name' => 'name',
            'email' => 'test@gmail.com',
            'password' => '123123123',
        ];
        $response = $this->json('POST','/api/register',$user);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users',[
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
        $response->assertJson([
            'message'=>'User registered successfully!!!',
        ]);
    }

    public function test_user_login_successfully()
    {
        $user= User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => '123123123',
        ]);
        $response = $this->json('POST','/api/login',[
            'email'=>'test@gmail.com',
            'password'=>'123123123',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message'=>'User Login Successfully!!!',
        ]);
    }

    public function test_user_logout_successfully()
    {
//        $user = User::factory()->create();
//        $this->actingAs($user, 'sanctum');
//        $response = $this->postJson('/api/logout');
//        $response->assertStatus(200);
//        $response->assertJson([
//            'message' => 'Logout successfully & Removed Access Token',
//        ]);

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $response = $this->post('/api/logout');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logout successfully & Removed Access Token',
        ]);

    }
}
