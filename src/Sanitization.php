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
 * @version 1.0.7
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
        $data = $this->useTrim($value);
        $data = $this->useHtmlEntities($data);
        $data = $this->useFilterVar($data);
        $data = $this->useStripTags($data);
        return $data;
    }

    /**
     * Strip whitespace from the beginning and end of a string
     *
     * @param string $data
     *  The string that will be trimmed.
     * @param string $from_where
     *  Define from where do you want to trim whitespaces (Left, Right, Both)
     * @return string
     *  The trimmed string.
     */
    public function useTrim($data, $from_where = "both")
    {
        if ($from_where == "left") {
            $data = ltrim($data);
        }

        if ($from_where == "right") {
            $data = rtrim($data);
        }

        if ($from_where == "both") {
            $data = trim($data);
        }

        return $data;
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @param string $data
     *  The input string.
     * @param int $quote_style
     *  quote_style parameter lets you define what will be done with 'single' and "double" quotes.
     * @param string $charset
     *  used in conversion. Presently, the UTF-8 character set is used as the default
     * @return string
     *  The encoded string
     */
    public function useHtmlEntities($data, $quote_style = ENT_QUOTES, $charset = "UTF-8")
    {
        return htmlentities($data, $quote_style, $charset);
    }

    /**
     * Filters a variable with a specified filter
     *
     * @param mixed $data
     *  Value to filter.
     * @param int $filter
     *  The ID of the filter to apply. The manual page lists the available filters.
     * @return mixed
     *  the filtered data, or FALSE if the filter fails.
     */
    public function useFilterVar($data, $filter = FILTER_SANITIZE_STRING)
    {
        return filter_var($data, $filter);
    }

    /**
     * Strip HTML and PHP tags from a string
     *
     * @param string $data
     *  The input string.
     * @return string
     *  the stripped string.
     */
    public function useStripTags($data)
    {
        return strip_tags($data);
    }

    /**
     * Un-quotes a quoted string
     *
     * @param string $data
     *  The input string.
     * @return string
     *  String with backslashes stripped off, Double backslashes are made into a single backslash.
     */
    public function useStripSlashes($data)
    {
        return stripslashes($data);
    }

    /**
     * Convert special characters to HTML entities
     *
     * @param string $data
     *  The string being converted.
     * @param int $flags
     *  A bitmask of one or more of the following flags, which specify how to handle quotes
     * @param string $encoding
     *  Defines encoding used in conversion.
     * @return string
     *  The converted string.
     */
    public function useHtmlSpecialChars($data, $flags = ENT_QUOTES, $encoding = "UTF-8")
    {
        return htmlspecialchars($data, $flags, $encoding);
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

            if ($this->isEmpty($data)) {
                return false;
            }

            if ($this->isAssociative($data) == false) {
                foreach ($data as $value) {
                    $santizied[] = $this->sanitize($value);
                }
            }

            if ($this->isAssociative($data) == true) {
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
     * Setter for the $data variable
     *
     * @param mixed $data
     *  The input value to set it to the $data variable
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Getter for the $data variable
     *
     * @return mixed
     *  Return the value of the $data variable
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Check if the provided array is an associative or a sequential array
     *
     * @param array $arr
     *  The array you want to check it's type
     * @return boolean
     *  Return true if provided array is an associative or false otherwise
     */
    private function isAssociative(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Check if the provided variable is empty
     *
     * @param mixed $data
     *  The variable you want to check if it's empty or not
     * @return boolean
     *  Return true if the variable does not contain data or false otherwise
     */
    private function isEmpty($data)
    {
        $bool = false;

        if (is_array($data)) {
            $bool = array() === $data;
        }

        if (is_string($data)) {
            $bool = ($data == null);
        }

        return $bool;
    }
}
