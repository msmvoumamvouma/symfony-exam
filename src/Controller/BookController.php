<?php

namespace App\Controller;

use App\Service\SearchBook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    /**
     * return all namme of books in json format.
     */
    #[Route('/books/list', name: 'list-of-my-books', methods: ['GET'], format: 'json')]
    public function book(SearchBook $searchBook)
    {
        $allBookTitle  = $searchBook->retrieveAllBookTitle();

        return $this->json( $allBookTitle);
    }

    /**
     * parcour all books and add sufix on name.
     */
    #[Route('/books/add-sufix', name: 'add-sufix-on-my-books', methods: ['GET'], format: 'json')]
    public function addSufix(string $suffix)
    {
        $template = $this->container->get('twig')->load('book/index.html.twig');

        return $template->render([
            'return' => json_encode([
                'data' => json_encode('ok'),
                'books' => json_encode([]),
            ]),
        ]);
    }

}
