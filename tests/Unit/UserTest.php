<?php

namespace Tests\Unit;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        User::factory()
            ->count(2)
            ->create();

        $user = User::first();
        $this->actingAs($user,'api');
        $response = $this->get("/api/v1/user");
        $response->assertStatus(200);
        $this->assertTrue(true);
    }

    public function test_user_create()
    {
//        $user = User::first();
//        $this->actingAs($user,'api');
        $response = $this->json("POST", "/api/v1/user/create",[
            "name"=>"Bla bla",
            "email"=>"yarbek12211@gmail.com",
            "password"=>"12345"
        ]);

        $response->assertStatus(200);
        $this->assertTrue(true);
    }


}
