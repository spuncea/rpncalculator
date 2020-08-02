<?php 

namespace RPN\Utils;

final class Validate 
{
    /**
     * This class can not be initialized 
     */
    private function __construct() {
        // nothing to do
    }

    /**
     * Check if subject matches pattern
     *
     * @param string $subject String to search the pattern in
     * @param string $pattern The string pattern to be searched in $subject
     * @return boolean
     */
    public static function regexp($subject, $pattern)
    {
        $pattern = '/' . trim($pattern, '/') . '/';

        if (0 === preg_match($pattern, (string) $subject)) {
            return false;
        }

        return true;
    }

}