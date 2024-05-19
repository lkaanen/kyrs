<?php

namespace App\Services\Author;

class AuthorService
{
    private $storeAuthorService;

    public function __construct()
    {
        $this->storeAuthorService = new StoreAuthorService();
    }

    public function fileUpload($file, $folder, $title)
    {
        return $this->storeAuthorService->fileUpload($file, $folder, $title);
    }
}
