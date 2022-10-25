<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\GroupName;
use App\Exceptions\ValidationException;
use App\Repository\AuthorRepository;
use App\Response\ErrorResponse;
use App\Response\SaveAuthorResponse;
use App\Validator\AuthorValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HandleAuthor
{
    private AuthorDenormalizer $authorDenormalizer;

    private AuthorRepository $authorRepository;

    private ValidatorInterface $validator;

    public function __construct(AuthorDenormalizer $authorDenormalizer, AuthorRepository $authorRepository, ValidatorInterface $validator)
    {
        $this->authorDenormalizer = $authorDenormalizer;

        $this->authorRepository = $authorRepository;

        $this->validator = $validator;
    }

    public function addAuthor(string $jsonInputData): SaveAuthorResponse
    {
        $serializer = FactorySerializer::ofAuthorOnlyDenormalizer();

        /*** @var $author Author */
        $author = $serializer->deserialize($jsonInputData, Author::class, 'json');
        $authorValidator = new AuthorValidator($this->validator, Author::class, [GroupName::WRITE]);
        try {
            $violationsMessage = $authorValidator->validate($author);
            if (!empty($violationsMessage)) {
                throw new ValidationException(implode(', ', array_values($violationsMessage)));
            }

            $this->authorRepository->save($author, true);

            return new SaveAuthorResponse($author);
        } catch (ValidationException $e) {
            $error = new ErrorResponse('error', 'data validation', 'An validation error occurred', 400);

            return new SaveAuthorResponse($author, $error);
        } catch (\Throwable $ex) {
            return new SaveAuthorResponse($author, new ErrorResponse('error', 'An internal error occurred', $ex->getMessage(), 500));
        }
    }
}
