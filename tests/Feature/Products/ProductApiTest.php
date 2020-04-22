<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Category;
use App\Product;
use Carbon\Carbon;

class ProductApiTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();
        $this->product = factory(Product::class)->create(['category_id' => $category->id,'featured' => 1]);
    }

    /** @test */
    public function it_can_show_product_from_api() {
        $response = $this->json('GET', "api/products/{$this->product->id}");
        $expected= ['id'=>$this->product->id,
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'code'=>$this->product->code ,
                    'image' => NULL,
                    'category_id' => $this->product->category_id,
                    'created_at' =>Carbon::parse($this->product['created_at'])->toISOString(),
                    'updated_at' => Carbon::parse($this->product['updated_at'])->toISOString(),
                    'featured' => $this->product->featured,
                ];
        $response->assertStatus(200)    
             ->assertJson(['data' => $expected,'errors' => null , 'code' => 200 ,'msg' =>"Product Found"]);
    }

    /** @test */
    public function it_can_list_all_products_from_api() {
        $response = $this->json('GET', "api/products");
        $expected = [
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'image' => NULL,
                ];
        $response->assertStatus(200)    
             ->assertJson(['data' => [$expected],'errors' => null , 'code' => 200 ,'msg' =>'Listing successfully']);
    }

    /** @test */
    public function it_can_list_all_featured_products_from_api() {
        $response = $this->json('GET', "api/featured_products");
        $expected = [
                    'name' => $this->product->name,
                    'price' => $this->product->price,
                    'image' => NULL,
                ];
        $response->assertStatus(200)    
             ->assertJson(['data' => [$expected],'errors' => null , 'code' => 200 ,'msg' =>'Listing successfully']);
    }

}
