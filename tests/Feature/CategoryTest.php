<?php

namespace Tests\Feature;

use App\Models\Category;
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




    
    /**
     * A basic feature test example.
     */
    public function test_user_can_create_category(): void
    {

         #Arrange
         $category = Category::factory()->create();
        $category = $category->toArray();


        # Act
         $response = $this->post("category-update", $category);
        
         $response->dump();
         
        # Assert  
        $this->assertDatabaseHas('categories', [
            'category_name' => $category['category_name'],
            'category_short_detail' => $category['category_short_detail'],
            'parent_category_id' => $category['parent_category_id'],
            'category_icon_css' => $category['category_icon_css'],
            'added_by' =>  $category['added_by'],
            'updated_by' =>  $category['updated_by'],
            'status' => 1,
            ]
        );



    }






}
