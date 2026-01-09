<?php

declare(strict_types=1);

namespace PhpSanitization\PhpSanitization;

/**
 * PHP Sanitization Class
 *
 * A modern, secure class for sanitizing and validating data to prevent security issues 
 * such as XSS, SQL injection, and other attack vectors.
 *
 * Features include:
 * - Strong input sanitization for strings and arrays
 * - SQL query escaping
 * - Email validation
 * - Support for filtering with various PHP filter types
 * - Array sanitization (both sequential and associative)
 *
 * @package PhpSanitization
 * @version v2.0.0
 * @author fariscode <farisksa79@gmail.com>
 * @license MIT
 * @link https://github.com/farisc0de/phpsanitization
 */
final class Sanitization
{
    /**
     * PhpSanitization Class Constructor
     *
     * @param Utils $utils Utilities helper instance
     * @param mixed $data Optional initial data to sanitize
     */
    public function __construct(
        private readonly Utils $utils,
        private mixed $data = ""
    ) {
    }

    /**
     * Sanitize input value using multiple sanitization techniques
     *
     * @param string $value The input string to sanitize
     * @return string The sanitized string
     */
    private function sanitize(string $value): string
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
     * @param string $data The string to be trimmed
     * @param TrimDirection $fromWhere Where to trim: left, right, or both
     * @return string The trimmed string
     */
    public function useTrim(string $data, TrimDirection $fromWhere = TrimDirection::Both): string
    {
        return match ($fromWhere) {
            TrimDirection::Left => ltrim($data),
            TrimDirection::Right => rtrim($data),
            TrimDirection::Both => trim($data),
        };
    }

    /**
     * Convert all applicable characters to HTML entities
     *
     * @param string $data The input string
     * @param int $quoteStyle How to handle quotes (default: ENT_QUOTES | ENT_HTML5)
     * @param string $charset Character set for conversion (default: UTF-8)
     * @return string The encoded string
     */
    public function useHtmlEntities(string $data, int $quoteStyle = ENT_QUOTES | ENT_HTML5, string $charset = "UTF-8"): string
    {
        return htmlentities($data, $quoteStyle, $charset);
    }

    /**
     * Filters a variable with a specified filter
     *
     * @param mixed $data Value to filter
     * @param int $filter The ID of the filter to apply
     * @param array<string,mixed>|int $options Filter options
     * @return mixed The filtered data, or FALSE if the filter fails
     */
    public function useFilterVar(mixed $data, int $filter = FILTER_DEFAULT, array|int $options = 0): mixed
    {
        return filter_var($data, $filter, $options);
    }

    /**
     * Strip HTML and PHP tags from a string
     *
     * @param string $data The input string
     * @param string|null $allowedTags Optional tags to allow
     * @return string The stripped string
     */
    public function useStripTags(string $data, ?string $allowedTags = null): string
    {
        return strip_tags($data, $allowedTags);
    }

    /**
     * Un-quotes a quoted string
     *
     * @param string $data The input string to unquote
     * @return string String with backslashes stripped off
     */
    public function useStripSlashes(string $data): string
    {
        return stripslashes($data);
    }

    /**
     * Convert special characters to HTML entities
     *
     * @param string $data The string being converted
     * @param int $flags A bitmask of flags to handle quotes (default: ENT_QUOTES | ENT_HTML5)
     * @param string $encoding Character encoding (default: UTF-8)
     * @return string The converted string
     */
    public function useHtmlSpecialChars(string $data, int $flags = ENT_QUOTES | ENT_HTML5, string $encoding = "UTF-8"): string
    {
        return htmlspecialchars($data, $flags, $encoding);
    }

    /**
     * Perform a regular expression search and replace
     *
     * @param string|array<string> $pattern The pattern to search for
     * @param string|array<string> $data The input to search and replace
     * @param string|array<string> $replacement The replacement string/array
     * @return string|array<string>|null The processed string/array or null on error
     */
    public function usePregReplace(string|array $pattern, string|array $data, string|array $replacement = ""): string|array|null
    {
        return preg_replace($pattern, $replacement, $data);
    }

    /**
     * Replace all occurrences of the search string with the replacement string
     *
     * @param string|array<string> $search The value being searched for
     * @param string|array<string> $replace The replacement value
     * @param string|array<string> $subject The string/array being searched (haystack)
     * @return string|array<string> The string/array with replaced values
     */
    public function useStrReplace(string|array $search, string|array $replace, string|array $subject): string|array
    {
        return str_replace($search, $replace, $subject);
    }

    /**
     * Escape SQL queries to prevent SQL injection
     *
     * @param string $value The SQL query to escape
     * @return string The escaped SQL query
     */
    private function escape(string $value): string
    {
        // Define the characters to be escaped
        $chars = [
            '\\' => '\\\\',
            '\0' => '\\0',
            '\n' => '\\n',
            '\r' => '\\r',
            '\x1a' => '\Z',
            '\'' => '\\\'',
            '"' => '\\"'
        ];
        
        return strtr($value, $chars);
    }
    /**
     * Sanitize input data - works with strings, arrays, and associative arrays
     *
     * Usage:
     *  $sanitizer->useSanitize($_POST["username"]);
     *
     * @param mixed $data The data to sanitize (optional if set in constructor)
     * @return string|array<mixed>|false Sanitized data or false if invalid
     */
    public function useSanitize(mixed $data = ""): string|array|false
    {
        // Use data provided in constructor if none provided to method
        if ($data === "" && $this->data !== "") {
            $data = $this->data;
        }

        // Handle string input
        if (is_string($data)) {
            if ($this->utils->isEmpty($data)) {
                return false;
            }
            return $this->sanitize($data);
        }

        // Handle array input
        if (is_array($data)) {
            return $this->sanitizeArray($data);
        }

        return false;
    }

    /**
     * Sanitize an array (associative or sequential)
     *
     * @param array<mixed> $data The array to sanitize
     * @return array<mixed>|false Sanitized array or false if empty
     */
    private function sanitizeArray(array $data): array|false
    {
        if ($this->utils->isEmpty($data)) {
            return false;
        }

        $sanitized = [];

        // Handle sequential arrays
        if (!$this->utils->isAssociative($data)) {
            foreach ($data as $value) {
                // Recursively handle nested arrays
                if (is_array($value)) {
                    $sanitized[] = $this->sanitizeArray($value);
                } else if (is_string($value)) {
                    $sanitized[] = $this->sanitize($value);
                } else {
                    $sanitized[] = $value;
                }
            }
        } else {
            // Handle associative arrays
            foreach ($data as $key => $value) {
                $sanitizedKey = is_string($key) ? $this->sanitize($key) : $key;
                
                // Recursively handle nested arrays
                if (is_array($value)) {
                    $sanitized[$sanitizedKey] = $this->sanitizeArray($value);
                } else if (is_string($value)) {
                    $sanitized[$sanitizedKey] = $this->sanitize($value);
                } else {
                    $sanitized[$sanitizedKey] = $value;
                }
            }
        }

        return $sanitized;
    }

    /**
     * Escape SQL queries to prevent SQL injection
     *
     * Usage:
     *  $sanitizer->useEscape("SELECT * FROM `users` WHERE `username` = 'admin'");
     *
     * @param string $data The SQL query to escape
     * @return string|false The escaped SQL query or false if empty
     */
    public function useEscape(string $data = ""): string|false
    {
        // Use data provided in constructor if none provided to method
        if ($data === "" && $this->data !== "") {
            $data = $this->data;
        }

        if ($this->utils->isEmpty($data)) {
            return false;
        }

        return $this->escape($data);
    }

    /**
     * Validate email address with additional security checks
     *
     * @param string $email The email address to validate
     * @param array<string> $providers List of allowed email providers (domains)
     * @param bool $checkDns Whether to perform DNS check on the domain
     * @return bool True if the email is valid, false otherwise
     */
    public function validateEmail(string $email, array $providers = [], bool $checkDns = true): bool
    {
        // First sanitize the email
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if (!$sanitizedEmail || $sanitizedEmail !== $email) {
            return false; // Email contained invalid characters
        }
        
        // Basic validation with PHP's filter
        if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Extract the domain
        $atPosition = strpos($sanitizedEmail, '@');
        if ($atPosition === false) {
            return false;
        }
        
        $domain = strtolower(substr($sanitizedEmail, $atPosition + 1));
        
        // Default providers list if none provided
        if (empty($providers)) {
            $providers = [
                'gmail.com',
                'hotmail.com',
                'outlook.com',
                'msn.com',
                'aol.com',
                'protonmail.com',
                'yahoo.com',
                'icloud.com',
                'zoho.com',
                'mail.com',
                'yandex.com',
                'gmx.com'
            ];
        }
        
        // Check if domain is in allowed providers
        $domainValid = empty($providers) || in_array($domain, $providers, true);
        
        // Check DNS records if required
        $dnsValid = !$checkDns || checkdnsrr($domain, 'MX');
        
        return $domainValid && $dnsValid;
    }

    /**
     * Validate data with a specified filter
     *
     * @param mixed $data Value to validate
     * @param int $filter The filter ID to apply (see PHP documentation)
     * @param array<string,mixed>|int $options Filter options
     * @return mixed The filtered data, or FALSE if validation fails
     */
    public function isValid(mixed $data, int $filter, array|int $options = 0): mixed
    {
        return filter_var($data, $filter, $options);
    }

    /**
     * Set data for sanitization
     *
     * @param mixed $data The data to set
     * @return self For method chaining
     */
    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get the current data
     *
     * @return mixed The current data value
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Execute a callback function with arguments
     *
     * @param callable $function The callback function to execute
     * @param mixed $args Arguments to pass to the callback
     * @return mixed The callback function output
     * @throws \InvalidArgumentException If the function is not callable
     */
    public function callback(callable $function, mixed $args = null): mixed
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException('The provided function is not callable');
        }
        
        return call_user_func($function, $args);
    }
}
