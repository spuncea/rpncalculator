<?php 

namespace RPN;

use RPN\Utils\Regexp;
use RPN\Utils\Validate;

/**
 * Main Reverse Polish Notation Calculator class
 */
class Calculator extends AbstractCalculator {

    /**
     * Allowed operators
     * @param array
     */
    private static $allowedOperators = [
        self::OPERATOR_ADDITION,
        self::OPERATOR_SUBSTRACTION,
        self::OPERATOR_DIVISON,
        self::OPERATOR_MULTIPLICATION
    ];

    /**
     * Stack of numbers 
     * @param array 
     */
    private static $stack = [];

    /**
     * Wether the stack contains or not negative values
     * @param boolean 
     */
    private static $hasNegativeValue = false;

    /**
     * Wether the operations are done inline or not (one by one)
     */
    private static $inline = true;
    
    public function __construct()
    {
        // nothing to do
    }

    /**
     * Run the calculator app 
     */
    public function run() 
    {
        echo "* Please input your numbers and (or) operators separated by space ( ' ' )" . PHP_EOL;

        while (FALSE !== ($input = fgets(STDIN))) {
            
            $result = $this->calculate($input);
            if(!is_null($result)) {
                echo $result . PHP_EOL;
            }
        }
    }

    /**
     * Calculate a string with of numbers and operators separated by space
     * @param string $string The given input string ex: 26 6 2 12 - - +  
     */
    public function calculate($string)
    {
        $values = explode(' ', trim($string));

        // set the flag when not inline (single input)
        if (count($values) == 1) {
            $first = reset($values);
            if (Validate::regexp($first, Regexp::FRACTIONAL_NUMBER) || in_array($first, static::$allowedOperators)) {
                static::$inline = false;
            }
        }

        // set the flag when inline (multiple input)
        if (count($values) > 1) {
            static::$inline = true;
        }

        foreach ($values as $value) {
            if (empty($value)) {
                // nothing to do with empty values
                continue;
            }
            $result = $this->handleSingle($value);
        }

        // print the result when inline calculation 
        if (static::$inline) {
            $result = end(static::$stack);
        }

        return $result;
    }

    /**
     * Handle single value input    
     * @param string $value The value of an input
     * 
     * @return void
     */
    private function handleSingle($value)
    {
        if($value == 'q') { exit(1); };
        
        $result = null;

        // fractional number - add the number to the stack
        if(Validate::regexp($value, Regexp::FRACTIONAL_NUMBER)) {

            if(Validate::regexp($value, Regexp::NUMERIC_STRICT_NEGATIVE) && !static::$hasNegativeValue) {
                static::$hasNegativeValue = true;
            }

            if(static::$hasNegativeValue) {
                $value = number_format($value, 1);
            }

            // print the number only when the input is done one by one
            if(!static::$inline) {
                $result = $value;
            }

            static::$stack[] = $value;
        }
        // operator - do the math, add the result to the stack 
        else if(in_array($value, static::$allowedOperators)) {
            
            if(count(static::$stack) < 2) {
                $numbers = (2 - count(static::$stack));
                echo sprintf('Not enough numbers in stack. Add %s more number(s)' . PHP_EOL, $numbers);
                return;
            }
            // last element in stack
            $right = array_pop(static::$stack);
            // last but one element in stack
            $left = array_pop(static::$stack);
            
            switch ($value) {
                case static::OPERATOR_ADDITION:
                    $result = $left + $right;
                    break;
                case static::OPERATOR_SUBSTRACTION:
                    $result = $left - $right;
                    break;
                case static::OPERATOR_MULTIPLICATION: 
                    $result = $left * $right;
                    break;
                case static::OPERATOR_DIVISON:
                    $result = $left / $right;
                    break;
                default:
                    break;
            }
            // check if we have negative number results 
            if (Validate::regexp($result, Regexp::NUMERIC_STRICT_NEGATIVE) && !static::$hasNegativeValue) {
                static::$hasNegativeValue = true;
            }

            if (static::$hasNegativeValue) {
                $result = number_format($result, 1);
            }

            static::$stack[] = $result;
        }
        // not valid input
        else {
            echo sprintf('The value given ("%s") is invalid' . PHP_EOL, $value) ;
        }

        return $result;
    }
}