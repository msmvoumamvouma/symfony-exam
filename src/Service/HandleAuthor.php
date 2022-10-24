<?php

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class HandleAuthor
{
    private AuthorDenormalizer $authorDenormalizer;

    private AuthorRepository $authorRepository;

    public function __construct(AuthorDenormalizer $authorDenormalizer, AuthorRepository $authorRepository)
    {
        $this->authorDenormalizer = $authorDenormalizer;

        $this->authorRepository = $authorRepository;
    }

    public function addAuthor(string $jsonInputData)
    {
        $serializer = new Serializer(
            [$this->authorDenormalizer],
            [new JsonEncoder()]
        );
        /*** @var $author Author */
        $author = $serializer->deserialize($jsonInputData, Author::class, 'json');
        $this->authorRepository->save($author, true);
    }
}
