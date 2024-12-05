<?php

namespace Day_5\Part_2;

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

        if ($firstPageIndex === false || $secondPageIndex === false) {
            return true;
        }
        return $firstPageIndex < $secondPageIndex;
    }

    public function isInvalid(array $orderedPage): bool
    {
        $firstPageIndex = array_search($this->beforePage, $orderedPage, true);
        $secondPageIndex = array_search($this->afterPage, $orderedPage, true);

        if ($firstPageIndex === false || $secondPageIndex === false) {
            return false;
        }
        return $firstPageIndex > $secondPageIndex;
    }

    /**
     * @param int[][] $updates
     * @return int[][]
     * @throws \Exception
     */
    public function fixOrder(array $updates): array
    {
        $beforeOrdering = $updates;
        do {
            $secondPageIndex = array_search($this->afterPage, $updates, true);

            if ($secondPageIndex === count($updates) - 1) {
                echo implode(',', $updates) . " [$this->beforePage|$this->afterPage]\n";
                throw new \Exception("Ordering is impossible");
            }
            $pageAfter = $updates[$secondPageIndex + 1];
            $updates[$secondPageIndex] = $pageAfter;
            $updates[$secondPageIndex + 1] = $this->afterPage;
        } while ($this->isInvalid($updates));
        echo "ordering " . implode(
                ',',
                $beforeOrdering,
            ) . " with rule [$this->beforePage|$this->afterPage] => " . implode(',', $updates) . "\n";
        return $updates;
    }
}