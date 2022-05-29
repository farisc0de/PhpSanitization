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
 * @version v1.0.11
 * @author fariscode <farisksa79@gmail.com>
 * @license MIT
 * @link https://github.com/farisc0de/phpsanitization
 */
final class Sanitization
{
    /**
     * PhpSanitization Class Constructor
     *
     * @param mixed $data
     *  The value of the malicious string you want to sanitize
     */
    public function __construct(private $utils, private $data = "")
    {
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
     * @param string $fromWhere
     *  Define from where do you want to trim whitespaces (Left, Right, Both)
     * @return string
     *  The trimmed string.
     */
    public function useTrim($data, $fromWhere = "both")
    {
        if ($fromWhere == "left") {
            $data = ltrim($data);
        }

        if ($fromWhere == "right") {
            $data = rtrim($data);
        }

        if ($fromWhere == "both") {
            $data = trim($data);
        }

        return $data;
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @param string $data
     *  The input string.
     * @param int $quoteStyle
     *  quote_style parameter lets you define what will be done with 'single' and "double" quotes.
     * @param string $charset
     *  used in conversion. Presently, the UTF-8 character set is used as the default
     * @return string
     *  The encoded string
     */
    public function useHtmlEntities($data, $quoteStyle = ENT_QUOTES, $charset = "UTF-8")
    {
        return htmlentities($data, $quoteStyle, $charset);
    }

    /**
     * Filters a variable with a specified filter
     *
     * @param mixed $data
     *  Value to filter.
     * @param int $filter
     *  The ID of the filter to apply.
     * @return mixed
     *  the filtered data, or FALSE if the filter fails.
     */
    public function useFilterVar($data, $filter = FILTER_DEFAULT)
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
     * Perform a regular expression search and replace
     *
     * @param mixed $pattern
     *  The pattern to search for. It can be either a string or an array with strings.
     * @param mixed $data
     *  The string or an array with strings to search and replace.
     * @param mixed $replacement
     *  The string or an array with strings to replace.
     * @return mixed
     *  Returns an array if the subject parameter is an array, or a string otherwise.
     */
    public function usePregReplace($pattern, $data, $replacement = "")
    {
        return preg_replace($pattern, $replacement, $data);
    }

    /**
     * Replace all occurrences of the search string with the replacement string
     *
     * @param mixed $search
     *  The value being searched for. An array may be used to designate multiple needles.
     * @param mixed $replace
     *  The replacement value that replaces found search values.
     * @param mixed $subject
     *  The string or array being searched and replaced on, otherwise known as the haystack
     * @return mixed
     *  This function returns a string with the replaced values.
     */
    public function useStrReplace($search, $replace, $subject)
    {
        return str_replace($search, $replace, $subject);
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
        $data = $this->useStrReplace(
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
    public function useSanitize($data = "")
    {
        if ($this->data != null) {
            $data = $this->data;
        }

        if (is_string($data)) {
            if ($this->utils->isEmpty($data)) {
                return false;
            }

            return $this->sanitize($data);
        }

        if (is_array($data)) {
            return $this->sanitizeArray($data);
        }

        return false;
    }

    private function sanitizeArray($data)
    {
        $santizied = [];

        if ($this->utils->isEmpty($data)) {
            return false;
        }

        if ($this->utils->isAssociative($data) == false) {
            foreach ($data as $value) {
                $santizied[] = $this->sanitize($value);
            }
        }

        if ($this->utils->isAssociative($data) == true) {
            foreach ($data as $key => $value) {
                $santizied[$this->sanitize($key)] = $this->sanitize($value);
            }
        }
    }

    /**
     * Escape SQL Queries
     *
     * Usage:
     *  $sanitizer->useEscape("SELECT * FROM `users` WHERE `username` = 'admin'");
     *
     * @param string $data
     *  The SQL query you want to escape
     * @return mixed
     *  Return the escaped SQL query or false otherwise
     */
    public function useEscape($data = "")
    {
        if ($this->data != null) {
            $data = $this->data;
        }

        if ($this->utils->isEmpty($data)) {
            return false;
        }

        return $this->escape($data);
    }

    /**
     * Simple email validation method
     *
     * @param string $email
     *  The email address you want to validate
     * @param array $providers
     *  The list of providers to validate aginst
     * @return bool
     *  Return true if the the email is valid or false otherwise
     */
    public function validateEmail($email, $providers = [])
    {
        $email = $this->useFilterVar($email, FILTER_SANITIZE_EMAIL);
        $domain = strtolower(substr($email, strpos($email, '@') + 1));
        if ($this->utils->isEmpty($providers)) {
            $providers = [
                'gmail.com',
                'hotmail.com',
                'outlook.com',
                'msn.com',
                'aol.com',
                'protonmail.com'
            ];
        }
        return ($this->useFilterVar($email, FILTER_VALIDATE_EMAIL) &&
            in_array($domain, $providers) &&
            checkdnsrr($domain) != false);
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
    public function isValid($data, $flag)
    {
        return $this->useFilterVar($data, $flag);
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
     * Create a callback function when needed after or before an operation
     *
     * @param callback $function
     *  A callback function to execute
     * @param mixed $args
     *  A single paramter or an array that contains multiple paramters
     * @return mixed
     *  Return the callback function output
     */
    public function callback($function, $args = null)
    {
        if (is_callable($function)) {
            return call_user_func_array($function, $args);
        }
    }
}
