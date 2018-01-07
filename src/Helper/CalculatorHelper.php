<?php
namespace App\Helper;

class CalculatorHelper
{

    public static function calculate($num1, $num2, $operator)
    {
        $accepted_operators = array("plus", "subtract", "multiply", "divide");

        if (!in_array($operator, $accepted_operators)) {
            throw new \Exception("Operator not valid");
        }

        switch($operator) {
            case "plus":
                $result = $num1 + $num2;
                break;
            case "subtract":
                $result = $num1 - $num2;
                break;
            case "multiply":
                $result = $num1 * $num2;
                break;
            case "divide":
                $result = $num1 / $num2;
                break;

        }

        return $result;

    }

}
