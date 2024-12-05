<?php

namespace Day_5\Part_2;

class RuleManager
{
    /**
     * @param Rule[] $rules
     */
    public function __construct(private readonly array $rules) {}

    public static function loadFile(string $filePath): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);

        $rules = [];
        foreach ($lines as $line) {
            [$beforePage, $afterPage] = array_map('intval', explode('|', $line));
            $rules[] = new Rule($beforePage, $afterPage);
        }

        return new self($rules);
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param int $page
     * @return Rule[]
     */
    public function getAppliedRules(int $page): array
    {
        $appliedRules = [];
        foreach ($this->rules as $rule) {
            if ($rule->doesRuleApply($page)) {
                $appliedRules[] = $rule;
            }
        }
        return $appliedRules;
    }
}