<?php

declare(strict_types=1);

namespace PhpSanitization\PhpSanitization;

/**
 * Utility functions for sanitization operations
 *
 * @package PhpSanitization
 */
class Utils
{
    /**
     * Check if the provided array is associative or sequential
     *
     * @param array<int|string,mixed> $array The array to check
     * @return bool True if array is associative, false if sequential
     */
    public function isAssociative(array $array): bool
    {
        if (empty($array)) {
            return false;
        }
        
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Check if the provided variable is empty
     *
     * @param mixed $data The variable to check
     * @return bool True if the variable is empty, false otherwise
     */
    public function isEmpty(mixed $data): bool
    {
        if (is_array($data)) {
            return empty($data);
        }

        if (is_string($data)) {
            return trim($data) === '';
        }

        return empty($data);
    }
}
