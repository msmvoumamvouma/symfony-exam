<?php

namespace App\Tests\tests\Components\Service;

use App\Entity\Author;
use App\Service\AuthorDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class AuthorDenormalizerTest extends TestCase
{
    public function testDenormalizer()
    {
        $stringJsonData = '{
            "name": "kent",
             "firstName": "beck",
             "books": [
                 {
                     "title": "GOT",
                     "resume": "GOT"
                 },
                  {
                     "title": "HOD",
                     "resume": "HOD"
                 }
             ]
        }';
        $authorDenormalizer = new AuthorDenormalizer();
        $serializer = new Serializer(
           [$authorDenormalizer],
            [new JsonEncoder()]
        );
        /*** @var $author Author */
        $author = $serializer->deserialize($stringJsonData, Author::class, 'json');
        self::assertEquals('kent', $author->getName());
        self::assertEquals('beck', $author->getFirstName());
        self::assertEquals(2, $author->getNumberOfBook());
    }
}
