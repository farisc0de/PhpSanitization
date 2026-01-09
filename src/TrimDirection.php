<?php

declare(strict_types=1);

namespace PhpSanitization\PhpSanitization;

/**
 * Enum representing the direction for trimming whitespace
 *
 * @package PhpSanitization
 */
enum TrimDirection: string
{
    case Left = 'left';
    case Right = 'right';
    case Both = 'both';
}
