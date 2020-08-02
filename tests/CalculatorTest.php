<?php 

use PHPUnit\Framework\TestCase;
use RPN\Calculator;

class CalculatorTest extends TestCase {

    public function testAddition()
    {
        $calculator = new Calculator();
        $this->assertEquals('1.0', $calculator->calculate('-4 5 +'));
    }

    public function testDivision()
    {
        $calculator = new Calculator();
        $this->assertEquals('2.5', $calculator->calculate('5 2 /'));
    }

    public function testAdditionMultiplicationSubstraction()
    {
        $calculator = new Calculator();
        $this->assertEquals('14.0', $calculator->calculate('5 1 2 + 4 * 3 - +'));
    }

    public function testMultiplicationAdditionDivision()
    {
        $calculator = new Calculator();
        $this->assertEquals(2, $calculator->calculate('4 2 5 * + 1 3 2 * + /'));
    }

    public function testCalculatePrintsErrorOutput()
    {
        $calculator = new Calculator();
        $expected = 'The value given ("test") is invalid' . PHP_EOL;
        $this->expectOutputString($expected);
        $calculator->calculate('test');
    }
}