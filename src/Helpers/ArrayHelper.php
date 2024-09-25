<?php

namespace Turkpin\Maker\Helpers;

class ArrayHelper
{
    public static function arrayMergeRecursiveDistinct(array &$array1, array &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => $value) {
            $merged[$key] = (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) ? self::arrayMergeRecursiveDistinct($merged[$key], $value) : $value;
        }

        return $merged;
    }
}
