<?php

namespace App\Tests\Components\Response;

use App\Service\Common;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function testRetrieveAllValueInRecursiveWay()
    {
        $animals = ['c' => 'chimpanzee', 'go' => 'gorilla', 'do' => 'Dogs'];
        $numbers = [1, 2, 3, 4];
        $usersX = [
            'username' => 'kent',
            'firstName'=> 'John',
            'lastName'=> 'beck',
        ];
        $data = array_merge($usersX, $animals,  $numbers);
        $expected = [...array_values($usersX), ...array_values($animals), ...array_values($numbers)];
        $result = Common::boo($data);

        self::assertEquals($expected, $result);
    }
}
