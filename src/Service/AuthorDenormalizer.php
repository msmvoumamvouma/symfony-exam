<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AuthorDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        $rawData = $data;
        $bookFieldName = 'books';
        $rawBook = $data[$bookFieldName] ?? [];
        unset($rawData[$bookFieldName]);
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter);
        /*** @var $author Author */
        $author = $normalizer->denormalize($rawData, $type);
        foreach ($rawBook as $item) {
            $book = $normalizer->denormalize($item, Book::class);
            $author->addBook($book);
        }

        return $author;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Author::class === $type && 'json' === $format;
    }
}
