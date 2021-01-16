<?php

namespace PhpSanitization\PhpSanitization;

/**
 * Simple PHP Sanitization Class
 *
 * This is a simple class that can verify and clean values to assure they are valid.
 *
 * It can take a given string and remove or encode certain types of text values, so it can
 * be displayed in Web pages lowering the risk of being used to perform security attacks.
 *
 * The class can also sanitize arrays of data by processing the array values one by one.
 *
 * @package PhpSanitization
 * @version 1.0.4
 * @author fariscode <farisksa79@gmail.com>
 * @license MIT
 * @link https://github.com/fariscode511/phpsanitization
 */
class Sanitization
{

    /**
     * The value of the malicious string you want to sanitize
     *
     * @var mixed
     */
    private $data;

    /**
     * PhpSanitization Class Constructor
     *
     * @param mixed $data
     *  The value of the malicious string you want to sanitize
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Sanitize value
     *
     * @param string $value
     *  The value of the malicious string you want to sanitize
     * @return string
     *  Return the sanitized string
     */
    private function sanitize($value)
    {
        $data = trim($value);
        $data = htmlentities($data, ENT_QUOTES, "UTF-8");
        $data = filter_var($data, FILTER_SANITIZE_STRING);
        $data = strip_tags($data);
        return $data;
    }

    /**
     * Escape SQL Queries
     *
     * @param string $value
     *  The sql query you want to escape
     * @return string
     *  Return the escaped SQL query
     */
    private function escape($value)
    {
        $data = str_replace(
            array("\\", "\0", "\n", "\r", "\x1a", "'", '"'),
            array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'),
            $value
        );
        return $data;
    }
    /**
     * Sanatize an associative array, a sequential array or a string
     *
     * Usage:
     *  $sanitizer->useSanitize($_POST["username"]);
     *
     * @param mixed $data
     *  The value of the malicious string you want to sanitize
     * @return mixed
     *  Return a sanitized string, array, or associative array
     */
    public function useSanitize($data = null)
    {
        if ($this->data != null) {
            $data = $this->data;
        }

        if (is_string($data)) {
            if ($this->isEmpty($data)) {
                return false;
            }

            return $this->sanitize($data);
        }


        if (is_array($data)) {
            $santizied = [];

            if (array() === $data) {
                return false;
            }

            if ($this->isAssoc($data) == false) {
                foreach ($data as $value) {
                    $santizied[] = $this->sanitize($value);
                }
            } else {
                foreach ($data as $key => $value) {
                    $santizied[$this->sanitize($key)] = $this->sanitize($value);
                }
            }

            return $santizied;
        }
    }

    /**
     * Escape SQL Queries
     *
     * Usage:
     *  $sanitizer->useEscape("SELECT * FROM `users` WHERE `username` = 'admin'");
     *
     * @param string $value
     *  The SQL query you want to escape
     * @return string
     *  Return the escaped SQL query or false otherwise
     */
    public function useEscape($data = null)
    {
        if ($this->data != null) {
            $data = $this->data;
        }

        if ($this->isEmpty($data)) {
            return false;
        }

        return $this->escape($data);
    }

    /**
     * Check if the provided array is an associative or a sequential array
     *
     * @param array $arr
     *  The array you want to check it's type
     * @return boolean
     *  Return true if provided array is an associative or false otherwise
     */
    private function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Check if the provided variable is empty
     *
     * @param string $data
     *  The variable you want to check if it's empty or not
     * @return boolean
     *  Return true if the variable does not contain data or false otherwise
     */
    private function isEmpty($data)
    {
        return (empty($data) || $data == "" || strlen($data) == 0);
    }
}
