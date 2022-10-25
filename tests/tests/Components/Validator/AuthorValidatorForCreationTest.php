<?php

namespace App\Tests\tests\Components\Validator;

use App\Entity\Author;
use App\Service\BaseValidation;
use App\Tests\tests\Components\Utilities\ComponentFactory;
use PHPUnit\Framework\TestCase;

class AuthorValidatorForCreationTest extends TestCase
{
    public function testValidateAuthorWithoutBooksAndFirstName()
    {
        $author = new Author();
        $author->setName("fowler");
        $validator = ComponentFactory::createValidator();
        $validator = new BaseValidation( $validator, Author::class,  ['write'] );
        $violationMessages = $validator->validate($author);
        $errorMessageFirstName = "firstName This value should not be null.";
        $errorMessageCountNumberOfBook = "books You must specify at least one book";
        self::assertEquals( $errorMessageFirstName,  $violationMessages['firstName']);
        self::assertEquals( $errorMessageFirstName,  $violationMessages['firstName']);
        self::assertEquals([$errorMessageFirstName, $errorMessageCountNumberOfBook], array_values( $violationMessages));
    }
}
