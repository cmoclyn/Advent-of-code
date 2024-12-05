<?php

namespace Day_2\Part_2;

class Report
{
    public function __construct(private readonly array $numbers) {}

    public function isSafe(int $minDiff, int $maxDiff): bool
    {
        foreach ($this->numbers as $index => $number) {
            if ($this->isSafeWithoutThisOne($index, $minDiff, $maxDiff)) {
                return true;
            }
        }
        return false;
    }

    public function isSafeWithoutThisOne(int $index, int $minDiff, int $maxDiff): bool
    {
        $isIncreasing = null;
        $lastNumber = null;
        foreach ($this->numbers as $key => $number) {
            if ($key === $index) {
                continue;
            }

            if (null === $lastNumber) {
                $lastNumber = $number;
                continue;
            }

            if (null === $isIncreasing) {
                $isIncreasing = $lastNumber < $number;
            }

            if ($isIncreasing !== $lastNumber < $number) {
                return false;
            }

            $differ = abs($number - $lastNumber);
            if ($differ < $minDiff || $differ > $maxDiff) {
                return false;
            }

            $lastNumber = $number;
        }
        return true;
    }

    public function __toString(): string
    {
        return "[" . implode(", ", $this->numbers) . "]";
    }
}