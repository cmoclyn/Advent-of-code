<?php

namespace Day_2\Part_1;

readonly class ReportManager
{
    /** @param Report[] $reports */
    private function __construct(
        private array $reports,
        private int $minDiff,
        private int $maxDiff,
    ) {}

    public static function loadFile(string $filePath, int $minDiff, int $maxDiff): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $lists = explode("\n", $content);

        $reports = [];
        foreach ($lists as $listStr) {
            $list = array_map('intval', explode(" ", $listStr));
            $reports[] = new Report($list);
        }
        return new self($reports, $minDiff, $maxDiff);
    }

    public function countSafe(): void
    {
        $nbSafe = 0;
        foreach ($this->reports as $report) {
            if ($report->isSafe($this->minDiff, $this->maxDiff)) {
                $this->output($report->__toString().' is safe');
                $nbSafe++;
            }
            $this->output($report->__toString().' is not safe');
        }
        $this->output("Number of safe report : $nbSafe");
    }

    private function output(mixed $data): void
    {
        echo "$data\n";
    }
}