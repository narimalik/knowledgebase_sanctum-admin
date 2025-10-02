<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class UserTest extends TestCase
{


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
    public function test_can_access_homepage(): void
    {
        ob_start(); // start buffer
            $response = $this->get('/login');
            $response->assertStatus(200);
            $output = ob_get_clean();

            if (!empty($output)) {
                #dd($output);
            }

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
                    ->assertStatus(200)
                    //->assertSee('Dashboard')
                    ;
        # Assert
        $res = $loggedin->get("/dashboard");
        $res->assertStatus(200);

    }











}