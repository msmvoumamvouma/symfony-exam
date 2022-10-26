<?php

namespace App\Controller;

use App\Entity\GroupName;
use App\Service\HandleAddAuthor;
use App\Service\SearchAllAuthors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'search_authors', methods: ['GET'])]
    public function search(Request $request, SearchAllAuthors $searchAllAuthors): JsonResponse
    {
        $params = $request->query->all();
        $result = $searchAllAuthors->search($params);

        return $this->json($result, 200, [], GroupName::GROUPS_ONLY_FILTERABLE);
    }

    #[Route('/author', name: 'add_authors', methods: ['POST'], format: 'json')]
    public function add(Request $request, HandleAddAuthor $handleAuthor): JsonResponse
    {
        $result = $handleAuthor->apply($request->getContent());

        return $this->json($result, $result->getErrorCode(), [], ['groups' => [GroupName::READ]]);
    }
}
