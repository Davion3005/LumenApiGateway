<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class BookService
{
    use ConsumesExternalService;

    /**
     * The bass uri to consume the authors service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to consume the authors service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

    /**
     * Obtain the full list of books from book service
     *
     * @return string
     */
    public function obtainBooks()
    {
        return $this->performRequest('GET', 'books');
    }

    /**
     * Obtain one single book using book service
     * @param $book
     *
     * @return string
     */
    public function obtainBook($book)
    {
        return $this->performRequest('GET', "/books/{$book}");
    }

    /**
     * Create one new book using book service
     * @param array $data
     *
     * @return string
     */
    public function createBook($data)
    {
        return $this->performRequest('POST', '/books/', $data);
    }

    /**
     * Edit one single book using book service
     * @param array $data
     * @param $book
     *
     * @return string
     */
    public function editBook($data, $book)
    {
        return $this->performRequest('PUT', "/books/{$book}", $data);
    }

    /**
     * Delete one single book using book service
     * @param $book
     *
     * @return string
     */
    public function deleteBook($book)
    {
        return $this->performRequest('DELETE', "/books/{$book}");
    }
}
