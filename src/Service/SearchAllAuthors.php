<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\GroupName;
use App\Repository\AuthorRepository;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class SearchAllAuthors
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @param array<string, string> $inputData
     *
     * @throws ExceptionInterface
     */
    protected function applyDenormalize(array $inputData): Author
    {
        $serializer = FactorySerializer::ofSerializerFromAnnotation();

        return $serializer->denormalize($inputData, Author::class, null, GroupName::GROUPS_ONLY_FILTERABLE);
    }

    /**
     * @return Author[]
     *
     * @throws ExceptionInterface
     */
    public function search(array $data): array
    {
        $author = $this->applyDenormalize($data);

        return $this->authorRepository->searchAllAuthors($author);
    }
}
