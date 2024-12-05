<?php

namespace Day_5\Part_1;

readonly class Rule
{
    public function __construct(private int $beforePage, private int $afterPage) {}

    public function getBeforePage(): int
    {
        return $this->beforePage;
    }

    public function getAfterPage(): int
    {
        return $this->afterPage;
    }

    public function doesRuleApply(int $page): bool
    {
        return $this->getBeforePage() === $page;
    }

    public function isValid(array $orderedPage): bool
    {
        $firstPageIndex = array_search($this->beforePage, $orderedPage, true);
        $secondPageIndex = array_search($this->afterPage, $orderedPage, true);

        if($secondPageIndex === false) {
            return true;
        }
        return $firstPageIndex < $secondPageIndex;
    }
}