<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'search_authors',  methods: ['GET'])]
    public function search(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $author = $serializer->deserialize($request->getContent(), Author::class, 'json');

        return $this->json($author);
    }
}
