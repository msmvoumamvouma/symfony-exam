<?php

namespace App\Tests\tests\Components\Utilities;


use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ComponentFactory
{
    public static function createValidator(): RecursiveValidator | ValidatorInterface
    {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping(true)
            ->addDefaultDoctrineAnnotationReader()
            ->getValidator()
        ;
    }

}
