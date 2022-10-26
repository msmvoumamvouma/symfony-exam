<?php

namespace App\Service;

use App\Entity\Book;
use App\Model\UpdateBookSuffix;
use App\Repository\BookRepository;
use App\Response\TreatmentResponse;
use App\Validator\BaseValidation;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HandleAddSuffixToAllBook extends ApplyTreatment
{
    private BookRepository $bookRepository;

    private BaseValidation  $validator;

    public function __construct(BookRepository $bookRepository, ValidatorInterface $validator, LoggerInterface $logger)
    {
        parent::__construct($validator, $logger);
        $this->bookRepository = $bookRepository;
        $this->validator = new BaseValidation($this->validatorInterface, UpdateBookSuffix::class, []);
    }

    protected function deserialize(string $jsonData): mixed
    {
        $serializer = FactorySerializer::ofSerializerFromAnnotation();

        return $serializer->deserialize($jsonData, UpdateBookSuffix::class, 'json');
    }

    /**
     * @return array<string, string>
     */
    protected function makeValidation(mixed $resultDeserialization): array
    {
        return $this->validator->validate($resultDeserialization);
    }

    /**
     * @return array<Book>
     *
     * @throws Exception
     */
    private function applyUpdateToDatabase(string $suffix): array
    {
        $books = $this->bookRepository->findAll();
        foreach ($books as $book) {
            $newTitle = sprintf('%s - %s', $book->getTitle(), $suffix);
            $book->setTitle($newTitle);
            $this->bookRepository->save($book, true);
        }

        return $books;
    }

    /**
     * @throws Exception
     */
    protected function addSuffixToAllBook(UpdateBookSuffix $bookSuffix): TreatmentResponse
    {
        $suffix = $bookSuffix->getSuffix();
        $books = $this->applyUpdateToDatabase($suffix);

        return new TreatmentResponse($books);
    }

    /**
     * @throws Exception
     */
    protected function doTheJob(mixed $resultDeserialization): TreatmentResponse
    {
        return $this->addSuffixToAllBook($resultDeserialization);
    }
}
