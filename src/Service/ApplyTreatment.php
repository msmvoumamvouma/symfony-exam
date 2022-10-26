<?php

namespace App\Service;

use App\Exceptions\ValidationException;
use App\Response\ErrorResponse;
use App\Response\SaveAuthorResponse;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeError;

abstract class ApplyTreatment
{
    protected ValidatorInterface $validatorInterface;

    protected LoggerInterface $logger;

    public function __construct(ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->validatorInterface = $validator;
        $this->logger = $logger;
    }

    abstract protected function deserialize(string $jsonData): mixed;

    /**
     * @throws Exception
     */
    abstract protected function doTheJob(mixed $resultDeserialization): SaveAuthorResponse;

    /**
     * @return array<string, string>
     *
     * @throws ValidationException
     */
    abstract protected function makeValidation(mixed $resultDeserialization): array;

    protected function createErrorWhenDecodeDataFailed(): SaveAuthorResponse
    {
        return new SaveAuthorResponse([], new ErrorResponse('error', 'data-format', 'An error occurred when decode data', 400));
    }

    protected function handleFailedToEncodeValue(): SaveAuthorResponse
    {
        return $this->createErrorWhenDecodeDataFailed();
    }

    protected function handleTypeError(): SaveAuthorResponse
    {
        return $this->createErrorWhenDecodeDataFailed();
    }

    public function apply(string $jsonData)
    {
        $resultDeserialization = null;
        try {
            $resultDeserialization = $this->deserialize($jsonData);
            $violationsMessage = $this->makeValidation($resultDeserialization);
            if (!empty($violationsMessage)) {
                throw new ValidationException(implode(', ', array_values($violationsMessage)));
            }

            return $this->doTheJob($resultDeserialization);
        } catch (NotEncodableValueException $ex) {
            $this->logger->error($ex->getMessage());

            return $this->handleFailedToEncodeValue();
        } catch (TypeError $typeError) {
            $this->logger->error($typeError->getMessage());

            return $this->handleTypeError();
        } catch (ValidationException $e) {
            $error = new ErrorResponse('error', 'data validation', $e->getMessage(), 400);

            return new SaveAuthorResponse($resultDeserialization, $error);
        } catch (\Throwable $ex) {
            $this->logger->error($ex->getMessage());

            return new SaveAuthorResponse($resultDeserialization, new ErrorResponse('error', 'internal error', 'An internal error occurred', 500));
        }
    }
}
