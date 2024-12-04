<?php

namespace Day_2\Part_1;

class Report
{
    private ?bool $isIncreasing = null;

    public function __construct(private readonly array $numbers) {}

    public function isSafe(int $minDiff, int $maxDiff): bool
    {
        $lastNumber = null;
        foreach ($this->numbers as $number) {
            if (null === $lastNumber) {
                $lastNumber = $number;
                continue;
            }

            if (null === $this->isIncreasing) {
                $this->isIncreasing = $lastNumber < $number;
            }

            if ($this->isIncreasing !== $lastNumber < $number) {
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
        return "[".implode(", ", $this->numbers)."]";
    }
}