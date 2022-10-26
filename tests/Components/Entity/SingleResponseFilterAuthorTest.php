<?php

namespace App\Tests\Components\Entity;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\GroupName;
use App\Service\FactorySerializer;
use PHPUnit\Framework\TestCase;

class SingleResponseFilterAuthorTest extends TestCase
{
    public function testSerialize()
    {
        $author = new Author();
        $author
            ->setName('kent')
            ->setFirstName('beck')
        ;

        $firstBook = new Book();
        $firstBook
            ->setTitle('xp')
            ->setResume('xp')
        ;

        $secondBook = new Book();
        $secondBook
          ->setTitle('tdd')
          ->setResume('tdd')
        ;

        $author->addBook($firstBook)->addBook($secondBook);

        $serializer = FactorySerializer::ofSerializerFromAnnotation();
        $result = $serializer->serialize($author, 'json', ['groups' => [GroupName::FILTERABLE]]);

        self::assertTrue(true);
        $expected = '{"id":null,"name":"kent","firstName":"beck","books":[{"title":"xp"},{"title":"tdd"}],"numberOfBook":2}';
        self::assertEquals($expected, $result);
    }
}
