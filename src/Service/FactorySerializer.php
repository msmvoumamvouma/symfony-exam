<?php

namespace App\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FactorySerializer
{
    public static function ofAuthorOnlyDenormalizer(): Serializer
    {
        return new Serializer(
            [new AuthorDenormalizer()],
            [new JsonEncoder()]
        );
    }

    public static function ofObjectNormalizer(): ObjectNormalizer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        return new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter);
    }
}
