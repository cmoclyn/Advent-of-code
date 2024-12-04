<?php

namespace Day_1\Part_2;

class ListNumbers
{
    private function __construct(private array $numbers)
    {
        $this->order();
    }

    public static function loadFile(string $filePath): self
    {
        if(!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $numbers = array_map('intval', explode("\n", $content));
        return new self($numbers);
    }

    private function order(): void
    {
        sort($this->numbers);
    }

    public function count(): int
    {
        return count($this->numbers);
    }

    public function get(int $index): int
    {
        return $this->numbers[$index];
    }

    public function howMany(int $number): int
    {
        return array_count_values($this->numbers)[$number] ?? 0;
    }
}
