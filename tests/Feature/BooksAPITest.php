<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksAPITest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function get_all_books()
    {
        $books = Book::factory(4)->create();

        $response = $this->getJson(route('books.index'));
        $response->assertJsonFragment([
            'title' => $books[0]->title
        ]);
        $response->assertJsonCount(4);
    }

    /** @test */
    function get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', $book));
        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    function create_book()
    {
        $book = [
            'title' => 'Principito'
        ];

        $response = $this->postJson(route('books.store'), []);
        $response->assertJsonValidationErrors(['title']);

        $response = $this->postJson(route('books.store'), $book);
        $response->assertJsonFragment([
            'title' => $book['title']
        ]);

        $this->assertDatabaseHas('books', [
            'title' => $book['title']
        ]);
    }

    /** @test */
    function update_book()
    {
        $updatedBook = [
            'title' => 'Chainsaw Man'
        ];

        $book = Book::factory()->create();

        $response = $this->patchJson(route('books.update', $book), []);
        $response->assertJsonValidationErrors(['title']);

        $response = $this->patchJson(route('books.update', $book), [
            'title' => $updatedBook['title']
        ]);
        $response->assertJsonFragment([
            'title' => $updatedBook['title']
        ]);

        $this->assertDatabaseHas('books', [
            'title' => $updatedBook['title']
        ]);
    }

    /** @test */
    function delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson(route('books.destroy', $book));
        $response->assertJsonFragment([
            'title' => $book->title
        ]);

        $this->assertDatabaseCount('books', 0);
    }
}
