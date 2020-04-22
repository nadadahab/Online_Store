<?php

namespace Tests\Unit\Products;


use App\Category;
use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();
        $this->product = factory(Product::class)->create(['category_id' => $category->id]);
    }

    /** @test */
    public function can_create_product()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create([
            'name' => 'product Tests One',
            'category_id' => $category->id
        ]);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($product->name,'product Tests One' );
    }

    /** @test */
    public function it_can_update_the_product()
    {
        $params = [
            'name' => 'product tests updated',
            'price' => 123,
            'code' =>2222
        ];

        $this->product->update($params);
        $updated = $this->product->refresh();
        $this->assertInstanceOf(Product::class, $updated);
        $this->assertEquals($params['name'], $updated->name);
        $this->assertEquals($params['price'], $updated->price);
        $this->assertEquals($params['code'], $updated->code);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $this->product->delete();
        $this->assertDatabaseMissing('products', collect($this->product)->all());
    }

    /** @test */
    public function it_can_list_all_the_products()
    {
        $attributes = $this->product->getFillable();

        $products = Product::all();

        $products->each(function ($product, $key) use ($attributes) {
            foreach ($product->getFillable() as $key => $value) {
                $this->assertArrayHasKey($key, $attributes);
            }
        });
    }  
}
