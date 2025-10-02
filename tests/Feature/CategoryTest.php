<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase; 
    
    /**
     * A basic feature test example.
     */
    public function test_user_can_see_category_list_page(): void
    {
         #Arrange
         $user = User::factory()->create();
        
         # Act
         $loggedin = $this->actingAs($user);
         $loggedin = $this->actingAs($user)
                     ->get("/category")
                     ->assertStatus(200);
 
 
         # Assert      
         $loggedin->assertStatus(200);

        #$response->assertStatus(200);
    }
}
