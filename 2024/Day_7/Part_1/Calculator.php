<?php

namespace Day_7\Part_1;

class Calculator
{
    private int $expectedResult;

    /** @var int[] $numbers */
    private array $numbers;

    private const array OPERATORS = ['+', '*'];

    public function __construct(private readonly string $input) {
        $explodedInput = explode(': ', $this->input);
        $this->expectedResult = (int)$explodedInput[0];
        $this->numbers = array_map('intval', explode(" ", $explodedInput[1]));
    }

    public function getAllCombinaisons() :array
    {
        foreach($this->numbers as $key => $number) {
            if($key === array_key_first($this->numbers)) {
                $possibilities = [" "];
            }

            if($key === array_key_last($this->numbers)) {
                foreach($possibilities as $index => $possibility) {
                    $possibilities[$index] .= " $number";
                }
                continue;
            }

            foreach($possibilities as $index => $possibility) {
//                echo "$possibility\n";
                $possibilities[$index] = $this->addOperators($possibility." $number");
            }

            $newPossibilites = [];
            foreach($possibilities as $possibility) {
                foreach($possibility as $strOperation) {
                    $newPossibilites[] = trim($strOperation);
                }
            }
            $possibilities = $newPossibilites;
//            var_dump($possibilities);
        }

        return $possibilities;
    }

    private function addOperators(string $operation): array
    {
        $nextOperations = [];

        foreach (self::OPERATORS as $operator) {
            $nextOperations[] = "$operation $operator";
        }
        return $nextOperations;
    }

    public function hasGoodCombinaisons() :bool
    {
        $combinaisons = $this->getAllCombinaisons();

        foreach($combinaisons as $combinaison) {
            $result = $this->calculOperation($combinaison);
//            echo "Combinaison : $combinaison = $result\n";

            if($result === $this->expectedResult) {
                echo "Combinaison trouvé ! - $this->expectedResult = $combinaison\n";
                return true;
            }
        }
        return false;
    }

    public function getExpectedResult() :int
    {
        return $this->expectedResult;
    }

    public function calculOperation(string $operation) :int
    {
        $result = 0;
        while(preg_match("/^(\d+)\s([\+\*])\s(\d+)/", $operation, $matches)) {
            $result = eval("return $matches[1] $matches[2] $matches[3];");
            $operation = preg_replace("/^(\d+)\s([\+\*])\s(\d+)/", $result, $operation);
        }
        return $result;
    }
}