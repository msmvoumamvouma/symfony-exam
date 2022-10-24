<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseValidation
{
    protected ValidatorInterface $validator;
    protected string $className;
    private array $groups;

    public function __construct(ValidatorInterface $validator, string $className, array $groups)
    {
        $this->validator = $validator;
        $this->className = $className;
        $this->groups = $groups;
    }

    private function readViolations(ConstraintViolationListInterface $violations): array
    {
        $result = [];
        /**
         * @var ConstraintViolation $violation
         */
        foreach ($violations as $violation) {
            $result[$violation->getPropertyPath()] = sprintf('%s %s', $violation->getPropertyPath(), $violation->getMessage());
        }

        return $result;
    }

    private function executeValidationWith($value): ConstraintViolationListInterface
    {
        return $this->validator->validate($value, null, $this->groups);
    }

    private function getViolationConstraint(object $theObject ): ConstraintViolationListInterface
    {

        return $this->executeValidationWith($theObject);
    }

    public function validate(object $theObject): array
    {
        $violations = $this->getViolationConstraint($theObject );

       return  $this->readViolations( $violations);
    }
}
