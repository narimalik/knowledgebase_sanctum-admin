<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class UserTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Avoid echo or print_r here
    }

    protected function tearDown(): void
    {
        // Avoid echo or debug output here
        parent::tearDown();
    }



      /**
     * A basic feature test example.
     */
    public function test_user_can_access_dashboard_with_login(): void
    {   

        #Arrange
        $user = User::factory()->create();
        
        # Act
        $loggedin = $this->actingAs($user);
        $loggedin = $this->actingAs($user)
                    ->get("/dashboard")
                    ->assertStatus(200);


        # Assert      
        $loggedin->assertStatus(200);

    }

    public function test_user_can_be_authenticate(){

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);


    }











}