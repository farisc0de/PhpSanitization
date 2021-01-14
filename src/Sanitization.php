<?php

namespace PhpSanitization\PhpSanitization;

/**
 * Simple PHP Sanitization Class
 *
 * @package PhpSanitization
 * @version 1.0
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
        $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
        $data = filter_var($data, FILTER_SANITIZE_STRING);
        $data = strip_tags($data);
        $data = str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $data);
        return $data;
    }
    /**
     * Like Codeigniter sanatize an associative array, a sequential array or a string
     *
     * @param mixed $data
     *  The value of the malicious string you want to sanitize
     * @return mixed
     *  Return a sanitized string, array, or associative array
     */
    public function esc($data = null)
    {
        if ($this->data != null) {
            $data = $this->data;
        }

        if (is_string($data)) {
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
     * Check if the provided array is an associative or a sequential array
     *
     * @param array $arr
     *  The array you want to check it's type
     * @return boolean
     *  Return true if provided array is an associative or false otherwise
     * 
     */
    private function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
