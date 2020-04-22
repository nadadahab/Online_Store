<?php

namespace Tests\Unit\Categories;

use App\Category;
use App\Product;
use Tests\TestCase;
class CategoryTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }

    /** @test */
    public function can_create_category()
    {
        $category = factory(Category::class)->create([
            'name' => 'Category Tests One'
        ]);
        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($category->name,'Category Tests One' );
    }

    /** @test */
    public function it_can_update_the_category()
    {
        $params = [
            'name' => 'Category tests updated',
            'details' => 'Category tests updated updated',
        ];

        $this->category->update($params);
        $updated = $this->category->refresh();
        $this->assertInstanceOf(Category::class, $updated);
        $this->assertEquals($params['name'], $updated->name);
        $this->assertEquals($params['details'], $updated->details);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $this->category->delete();
        $this->assertDatabaseMissing('categories', collect($this->category)->all());
    }

    /** @test */
    public function it_can_not_delete_a_category_has_products()
    {
        $product = factory(Product::class)->create(['category_id' => $this->category->id]);
        $this->assertEquals($this->category->can_be_deleted(), false);
    }

    /** @test */
    public function it_can_list_all_the_categories()
    {
        $attributes = $this->category->getFillable();

        $categories = Category::all();

        $categories->each(function ($category, $key) use ($attributes) {
            foreach ($category->getFillable() as $key => $value) {
                $this->assertArrayHasKey($key, $attributes);
            }
        });
    }


}
