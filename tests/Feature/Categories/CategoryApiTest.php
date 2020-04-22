<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use App\Category;
use App\Product;
use Carbon\Carbon;

class CategoryApiTest extends TestCase
{
  public function setUp(): void
  {
      parent::setUp();
      $this->category = factory(Category::class)->create();
  }

  /** @test */
  public function it_can_show_category_from_api() {
      $response = $this->json('GET', "api/categories/{$this->category->id}");
      $expected= ['id'=>$this->category->id,
                  'name' => $this->category->name,
                  'details' => $this->category->details,
                  'image' => NULL,
                  'created_at' =>Carbon::parse($this->category['created_at'])->toISOString(),
                  'updated_at' => Carbon::parse($this->category['updated_at'])->toISOString(),
              ];
      $response->assertStatus(200)    
            ->assertJson(['data' => $expected,'errors' => null , 'code' => 200 ,'msg' =>"Category Found"]);
  }

  /** @test */
  public function it_can_list_all_categories_from_api() {
      $response = $this->json('GET', "api/categories");
      $expected = [
                  'name' => $this->category->name,
                  'details' => $this->category->details,
                  'image' => NULL,
              ];
      $response->assertStatus(200)    
            ->assertJson(['data' => [$expected],'errors' => null , 'code' => 200 ,'msg' =>'Listing successfully']);
  }

  /** @test */
  public function it_can_list_all_products_in_a_category_from_api() {
      $product = factory(Product::class)->create(['category_id' => $this->category->id]);
      $response = $this->json('GET', "api/products_category/{$this->category->id}");
      $expected = [
                  'name' => $product->name,
                  'price' => $product->price,
                  'image' => NULL,
              ];
      $response->assertStatus(200)    
            ->assertJson(['data' => [$expected],'errors' => null , 'code' => 200 ,'msg' =>'Listing successfully']);
  }

}
