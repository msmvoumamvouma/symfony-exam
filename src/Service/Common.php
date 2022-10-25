<?php

namespace App\Service;

class Common
{
    /**
     * recursively retrieve all the values of an array using the reference of the array
     * containing the final result in the callback function
     */
    public static function boo(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function ($a) use (&$result) {
            $result[] = $a;
        });

        return $result;
    }

    /**
     * Merging two array, first array should not be associative,
     * second array must be associative with key k and value v
     */
    public static function foo(array $array1, array $array2): array
    {
        return [...$array1, $array2['k'] => $array2['v']];
    }

    /**
     * ???
     */
    public static function bar(array $array1, array $array2): bool
    {
        $r = array_filter(array_keys($array1), fn ($k) => !in_array($k, $array2));

        return 0 == count($r);
    }
}
