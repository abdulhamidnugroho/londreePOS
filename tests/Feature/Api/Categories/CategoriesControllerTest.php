<?php

namespace Tests\Feature\Api\Categories;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
    }

    public function testCategoryIndex()
    {
        $response = $this->json('GET', route('categories.index'), [], [], [], [
            "HTTP_Authorization" => "Bearer mytoken",
        ])->assertStatus(200);
    }

    public function testCategoryShow()
    {
        $response = $this->json('GET', route('categories.show', $this->category), [], [], [], [
            "HTTP_Authorization" => "Bearer mytoken",
        ])->assertStatus(200);
    }

    public function testCategoryStore()
    {
        $data = [
            'book_id'  => $this->category->book_id,
            'name' => $this->category->name,
            'updated_at' => $this->category->updated_at,
            'created_at' => $this->category->created_at
        ];

        $response = $this->json('POST', route('categories.store'), $data, [], [], [
            "HTTP_Authorization" => "Bearer mytoken",
        ])->assertStatus(200);
	}

    public function testCategoryUpdate()
    {
        $data = [
            'id' => $this->category->id,
            'book_id'  => $this->category->book_id,
            'name' => $this->category->name,
            'updated_at' => $this->category->updated_at,
            'created_at' => $this->category->created_at
        ];

        $this->json('PUT', route('categories.update', $this->category->id), $data, [], [], [
            "HTTP_Authorization" => "Bearer mytoken",
        ])->assertStatus(200);
    }

    public function testCategoryDelete()
    {
        $this->json('DELETE', route('categories.destroy', $this->category), [], [], [], [
            "HTTP_Authorization" => "Bearer mytoken",
        ])->assertStatus(204);
    }
}
