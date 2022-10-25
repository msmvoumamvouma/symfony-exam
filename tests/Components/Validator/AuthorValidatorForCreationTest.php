<?php

namespace App\Tests\Components\Validator;

use App\Entity\Author;
use App\Tests\Components\Utilities\ComponentFactory;
use App\Validator\AuthorValidator;
use PHPUnit\Framework\TestCase;

class AuthorValidatorForCreationTest extends TestCase
{
    public function testValidateAuthorWithoutBooksAndFirstName()
    {
        $author = new Author();
        $author->setName("fowler");
        $validator = ComponentFactory::createValidator();
        $validator = new AuthorValidator( $validator, Author::class,  ['write'] );
        $violationMessages = $validator->validate($author);
        $errorMessageFirstName = "firstName This value should not be null.";
        $errorMessageCountNumberOfBook = "books You must specify at least one book";
        self::assertEquals( $errorMessageFirstName,  $violationMessages['firstName']);
        self::assertEquals( $errorMessageFirstName,  $violationMessages['firstName']);
        self::assertEquals([$errorMessageFirstName, $errorMessageCountNumberOfBook], array_values( $violationMessages));
    }
}
