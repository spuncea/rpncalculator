<?php 

namespace RPN\Utils;

/**
 * Regular expressions helper
 */
final class Regexp 
{
    /**
     * This class can not be initialized
     */
    private function __construct()
    {
        // singleton 
    }

    /**
     * Regular expression to validate a numeric value
     */
    const NUMERIC = '/^(\d)*$/';

    /**
     * Regular expression to validate a fractional value
     */
    const FRACTIONAL_NUMBER = '/^(?!-0(\.0+)?$)-?(0|[1-9]\d*)(\.\d+)?$/';

    /**
     * Regular expression to validate a numeric strict negative value
     */
    const NUMERIC_STRICT_NEGATIVE = '/^-(\d)*$/';

}