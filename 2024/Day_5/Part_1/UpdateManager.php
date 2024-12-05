<?php

namespace Day_5\Part_1;

readonly class UpdateManager
{

    /**
     * @param int[][] $updates
     */
    public function __construct(private array $updates, private RuleManager $ruleManager) {}

    public static function loadFile(string $filePath, RuleManager $ruleManager): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        $updates = [];
        foreach ($lines as $line) {
            $updates[] = array_map('intval', explode(',', $line));
        }

        return new self($updates, $ruleManager);
    }

    public function getResult(): int
    {
        $orderedUpdates = $this->getOrderedUpdates();

        $sum = 0;
        foreach ($orderedUpdates as $orderedUpdate) {
            $middleValue = $this->getMiddleValue($orderedUpdate);
            $sum += $middleValue;
        }
        return $sum;
    }

    public function getOrderedUpdates(): array
    {
        $orderedUpdates = [];
        foreach ($this->updates as $orderedPage) {
            foreach ($orderedPage as $index => $page) {
                $rules = $this->ruleManager->getAppliedRules($page);
                foreach ($rules as $rule) {
                    if (!$rule->isValid($orderedPage)) {
                        continue 3;
                    }
                }
            }
            $orderedUpdates[] = $orderedPage;
        }
        return $orderedUpdates;
    }

    /**
     * @param int[] $orderedPage
     * @return int
     */
    public function getMiddleValue(array $orderedPage): int
    {
        $middleIndex = (count($orderedPage) -1 ) / 2;
        return $orderedPage[$middleIndex];
    }
}