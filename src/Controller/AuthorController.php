<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\GroupName;
use App\Service\HandleAddAuthor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'search_authors', methods: ['GET'])]
    public function search(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $context = ['groups' => [GroupName::READ]];

        $author = $serializer->deserialize($request->getContent(), Author::class, 'json',
            $context
        );

        return $this->json($author, 200, [], $context);
    }

    #[Route('/author', name: 'add_authors', methods: ['POST'])]
    public function add(Request $request, HandleAddAuthor $handleAuthor): JsonResponse
    {
        $result = $handleAuthor->apply($request->getContent());

        return $this->json($result, $result->getErrorCode(), [], ['groups' => [GroupName::READ]]);
    }
}
