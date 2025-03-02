<?php

namespace App\Validator;

use App\Entity\Author;
use App\Exceptions\ValidationException;

class AuthorValidator extends BaseValidation
{
    /**
     * @throws ValidationException
     */
    public function validate(mixed $theObject): array
    {
        /*** @var $theObject Author */
        if ($theObject instanceof Author) {
            $violations = parent::validate($theObject);
            foreach ($theObject->getBooks() as $book) {
                array_merge($violations, parent::validate($book));
            }

            return $violations;
        }

        throw new ValidationException('invalid class name');
    }
}
