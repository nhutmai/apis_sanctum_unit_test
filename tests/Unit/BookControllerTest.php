<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;


    //skip all test case in thí class
    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     $this->markTestSkipped('Temporary Stop All of Test Case..');
    // }

    public function test_index_returns_all_books()
    {
//        skip this test case
        // $this->markTestSkipped('Temporary Stop This Test Case...');

        Book::factory()->count(3)->create();

        $response = $this->get('/api/books');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_show_return_single_book()
    {
        $book = Book::factory()->create();
        $response = $this->get("/api/books/{$book->id}");
        $response->assertStatus(200);
        $response->assertJson($book->toArray());
    }

    public function test_store_creates_new_book()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $book=[
            'title'=>'test',
            'author'=>'test',
            'price'=>10
        ];
        $response = $this->post("/api/books",$book);
        $response->assertStatus(201);
        $this->assertDatabaseHas('books',$book);
    }

    public function test_update_edits_existing_book()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $updatedBook=[
            'title'=>'updated',
            'author'=>'updated',
            'price'=>10
        ];
        $response=$this->put("/api/books/{$book->id}",$updatedBook);
        $response->assertStatus(200);
        $this->assertDatabaseHas('books',$updatedBook);
    }

    public function test_destroy_deletes_book()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $book=Book::factory()->create();

        $response=$this->delete("/api/books/{$book->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', $book->toArray());

    }

    public function test_search_finds_books_by_title()
    {
        $book = Book::factory()->create(
            ['title'=>'test', 'author'=>'test', 'price'=>10]
        );
        $book2 = Book::factory()->create(
            ['title'=>'test1', 'author'=>'test', 'price'=>10]
        );
        $book3 = Book::factory()->create(
            ['title'=>'1test', 'author'=>'test', 'price'=>10]
        );

        $response = $this->get("/api/books?search=test");
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJson([$book->toArray(),$book2->toArray(),$book3->toArray()]
        );
    }

    public function test_filters_finds_books_by_title()
    {
        $book = Book::factory()->create(
            ['title'=>'test', 'author'=>'test', 'price'=>10]
        );
        $book2 = Book::factory()->create(
            ['title'=>'test1', 'author'=>'test1', 'price'=>10]
        );
        $book3 = Book::factory()->create(
            ['title'=>'1test', 'author'=>'2test', 'price'=>10]
        );

        $response = $this->get("/api/books?filter=test");
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJson([$book->toArray(),$book2->toArray(),$book3->toArray()]);
    }
}
