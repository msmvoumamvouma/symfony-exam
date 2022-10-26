<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\GroupName;
use App\Repository\AuthorRepository;
use App\Response\TreatmentResponse;
use App\Validator\AuthorValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HandleAuthor extends ApplyTreatment
{
    protected AuthorRepository $authorRepository;

    protected ValidatorInterface $validator;

    public function __construct(AuthorRepository $authorRepository, ValidatorInterface $validator, LoggerInterface $logger)
    {
        parent::__construct($validator, $logger);
        $this->authorRepository = $authorRepository;

        $this->validator = $validator;
    }

    protected function deserialize(string $jsonData): mixed
    {
        $serializer = FactorySerializer::ofAuthorOnlyDenormalizer();

        return $serializer->deserialize($jsonData, Author::class, 'json');
    }

    protected function doTheJob(mixed $resultDeserialization): TreatmentResponse
    {
        $this->authorRepository->save($resultDeserialization, true);

        return new TreatmentResponse($resultDeserialization);
    }

    protected function makeValidation(mixed $resultDeserialization): array
    {
        $authorValidator = new AuthorValidator($this->validatorInterface, Author::class, [GroupName::WRITE]);

        return $authorValidator->validate($resultDeserialization);
    }
}
