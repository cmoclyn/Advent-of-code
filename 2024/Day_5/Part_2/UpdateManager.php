<?php

namespace Day_5\Part_2;

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
        $notOrderedUpdates = $this->getNotOrderedUpdates();

        $sum = 0;
        foreach ($notOrderedUpdates as $notOrderedUpdate) {
            $orderedUpdate = $this->orderPageUpdate($notOrderedUpdate, $this->ruleManager->getRules());
            $middleValue = $this->getMiddleValue($orderedUpdate);
            echo implode(',', $notOrderedUpdate)." => ".implode(',', $orderedUpdate)." (middle : $middleValue)\n";
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
     * @return bool
     */
    public function orderIsValid(array $orderedPage): bool
    {
        $rules = $this->ruleManager->getRules();
        foreach ($rules as $rule) {
            if (!$rule->isValid($orderedPage)) {
                return false;
            }
        }
        return true;
    }

    public function getNotOrderedUpdates(): array
    {
        $notOrderedUpdates = [];
        foreach ($this->updates as $orderedPage) {
            foreach ($orderedPage as $index => $page) {
                $rules = $this->ruleManager->getAppliedRules($page);
                foreach ($rules as $rule) {
                    if ($rule->isInvalid($orderedPage)) {
                        $notOrderedUpdates[] = $orderedPage;
                        continue 3;
                    }
                }
            }
        }
        return $notOrderedUpdates;
    }

    /**
     * @param int[] $notOrderedPage
     * @param Rule[] $rules
     * @return int[]
     */
    public function orderPageUpdate(array $notOrderedPage, array $rules): array
    {
        $orderingUpdate = $notOrderedPage;
        while(!$this->orderIsValid($orderingUpdate)) {
            foreach ($rules as $rule) {
                foreach ($orderingUpdate as $page) {
                    if (!$rule->doesRuleApply($page)) {
                        continue;
                    }
                    if ($rule->isInvalid($orderingUpdate)) {
                        $orderingUpdate = $rule->fixOrder($orderingUpdate);
                    }
                }
            }
        }
        return $orderingUpdate;
    }

    /**
     * @param int[] $orderedPage
     * @return int
     */
    public function getMiddleValue(array $orderedPage): int
    {
        $middleIndex = (count($orderedPage) - 1) / 2;
        return $orderedPage[$middleIndex];
    }
}