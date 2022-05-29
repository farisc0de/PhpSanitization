<?php

namespace PhpSanitization\PhpSanitization;

class Utils
{
    /**
     * Check if the provided array is an associative or a sequential array
     *
     * @param array $array
     *  The array you want to check it's type
     * @return boolean
     *  Return true if provided array is an associative or false otherwise
     */
    public function isAssociative($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Check if the provided variable is empty
     *
     * @param mixed $data
     *  The variable you want to check if it's empty or not
     * @return boolean
     *  Return true if the variable does not contain data or false otherwise
     */
    public function isEmpty($data)
    {
        $bool = false;

        if (is_array($data)) {
            $bool = array() === $data;
        }

        if (is_string($data)) {
            $bool = ($data == "");
        }

        return $bool;
    }
}
