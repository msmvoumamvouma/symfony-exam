<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\GroupName;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AuthorDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $rawData = $data;
        $bookFieldName = 'books';
        $rawBook = $data[$bookFieldName] ?? [];
        unset($rawData[$bookFieldName]);

        $normalizer = FactorySerializer::ofObjectNormalizer();
        /*** @var $author Author */
        $author = $normalizer->denormalize($rawData, $type, null, GroupName::GROUPS_ONLY_WRITE);
        foreach ($rawBook as $item) {
            $book = $normalizer->denormalize($item, Book::class, null, GroupName::GROUPS_ONLY_WRITE);
            $author->addBook($book);
        }

        return $author;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Author::class === $type && 'json' === $format;
    }
}
