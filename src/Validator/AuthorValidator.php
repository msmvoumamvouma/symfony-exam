<?php

namespace App\Validator;

use App\Entity\Author;
use App\Exceptions\ValidationException;
use App\Service\BaseValidation;

class AuthorValidator extends BaseValidation
{
    /**
     * @throws ValidationException
     */
    public function validate(object $theObject): array
    {
        /*** @var $theObject Author */
        if ($theObject instanceof Author) {
            $violations = parent::validate($theObject);
            foreach ($theObject->getBooks() as $book) {
                array_merge($violations, $this->validate($book));
            }

            return $violations;
        }

        throw new ValidationException('invalid class name');
    }
}
