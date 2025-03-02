<?php

namespace App\Tests\Components\Response;

use App\Service\Common;
use PHPUnit\Framework\TestCase;

class CommonTest extends TestCase
{
    public function testRetrieveAllValueInRecursiveWay()
    {
        $animals = ['c' => 'chimpanzee', 'go' => 'gorilla', 'do' => 'Dogs'];
        $numbers = ['1' => 1, '2' => 2, '3' => 3,  '4' => 4];
        $usersX = [
            'username' => 'kent',
            'firstName' => 'John',
            'lastName' => 'beck',
        ];
        $data = array_merge($usersX, $animals, $numbers);
        $expected = [...array_values($usersX), ...array_values($animals), ...array_values($numbers)];
        $result = Common::boo($data);

        self::assertEquals($expected, $result);
    }

    public function testMergeArray()
    {
        $keyName = 'animals';
        $animals = ['chimpanzee', 'gorilla', 'Dogs'];
        $data = ['k' => $keyName, 'v' => $animals];
        $numbers = [1, 2, 3, 4];
        $result = Common::foo($numbers, $data);
        $expected = [...array_values($numbers), $keyName => $animals];

        self::assertEquals($expected, $result);
    }

    public function testAllKeyFound()
    {
        $users = [
            'username' => 'kent',
            'firstName' => 'John',
        ];
        $result = Common::bar($users, [...array_keys($users), '4', '7', 'got']);
        self::assertTrue($result);
    }
}
