<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Http\Request;

class AuthorService
{
    use ConsumesExternalService;

    /**
     * The bass uri to consume the authors service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to consume the author service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.authors.base_uri');
        $this->secret = config('services.authors.secret');
    }

    /**
     * Obtain the full list of author from author service
     */
    public function obtainAuthors()
    {
        return $this->performRequest('GET', '/authors');
    }

    /**
     * Create one new author using the author service
     * @param $data
     *
     * @return string
     */
    public function createAuthor($data)
    {
        return $this->performRequest('POST', '/authors', $data);
    }

    /**
     * Obtain one single of author from author service
     *
     * @param int $author
     * @return string
     */
    public function obtainAuthor($author)
    {
        return $this->performRequest('GET', "/authors/{$author}");
    }

    /**
     * Edit one author using author service
     * @param $data
     * @param $author
     *
     * @return string
     */
    public function editAuthor($data, $author)
    {
        return $this->performRequest('PUT', "authors/{$author}", $data);
    }

    public function deleteAuthor($author)
    {
        return $this->performRequest('DELETE', "authors/{$author}");
    }
}
