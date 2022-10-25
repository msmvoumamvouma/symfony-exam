<?php

namespace App\Service;

use App\Repository\BookRepository;

class SearchBook
{

    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }


    public function retrieveAllBookTitle(): array
    {
       return  $this->bookRepository->allBookTitle();
    }
}