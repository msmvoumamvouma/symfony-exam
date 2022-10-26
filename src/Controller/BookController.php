<?php

namespace App\Controller;

use App\Entity\GroupName;
use App\Service\HandleAddSuffixToAllBook;
use App\Service\SearchBook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private SearchBook $searchBook;

    public function __construct(SearchBook $searchBook)
    {
        $this->searchBook = $searchBook;
    }

    /**
     * return all namme of books in json format.
     */
    #[Route('/books/list', name: 'list-of-my-books', methods: ['GET'], format: 'json')]
    public function book()
    {
        $allBookTitle = $this->searchBook->retrieveAllBookTitle();

        return $this->json($allBookTitle);
    }

    /**
     * parcour all books and add sufix on name.
     */
    #[Route('/books/add-sufix', name: 'add-sufix-on-my-books', methods: ['PUT'], format: 'json')]
    public function addSufix(Request $request, HandleAddSuffixToAllBook $suffixToAllBook)
    {
        // The method Get does not allow updating of resource.
        $result = $suffixToAllBook->apply($request->getContent());

        return $this->json($result, $result->getErrorCode(), [], ['groups' => [GroupName::READ]]);
    }
}
