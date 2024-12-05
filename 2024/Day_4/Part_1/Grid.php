<?php

namespace Day_4\Part_1;

class Grid
{
    /** @var Direction[] $directions */
    private array $directions;

    private int $count;

    /**
     * @param Position[] $positions
     * @param int $maxX
     * @param int $maxY
     */
    private function __construct(
        private readonly array $positions,
        private readonly int $maxX,
        private readonly int $maxY,
    ) {
        $this->initDirections();
    }

    public static function loadFile(string $filePath): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);
        $maxY = count($lines);

        $positions = [];
        foreach ($lines as $y => $line) {
            $letters = str_split($line);
            $maxX = count($letters);
            foreach ($letters as $x => $letter) {
                $positions[] = new Position($x, $y, $letter);
            }
        }

        return new self($positions, $maxX, $maxY);
    }

    public function initDirections(): void
    {
        $possibleDirections = [-1, 0, 1];
        foreach ($possibleDirections as $directionY) {
            foreach ($possibleDirections as $directionX) {
                if ($directionY === 0 && $directionX === 0) {
                    continue;
                }
                $this->directions[] = new Direction($directionX, $directionY);
            }
        }
    }

    public function countWord(string $word): int
    {
        $currentLetterIndex = 0;
        $firstLetter = $word[$currentLetterIndex];
        $this->count = 0;

        foreach ($this->positions as $position) {
            if ($firstLetter === $position->getLetter()) {
                foreach ($this->directions as $direction) {
                    $this->hasNextLetter($word, 1, $position, $direction);
                }
            }
        }
        return $this->count;
    }

    public function hasNextLetter(string $word, int $currentIndex, Position $position, Direction $direction): bool
    {
        // On a dépassé la dernière lettre, toutes les lettres sont présentes
        if ($currentIndex === strlen($word)) {
            $this->count++;
            return true;
        }

        $wordArray = str_split($word);
        try {
            $nextPosition = $direction->getNextPosition($this, $position);
            if ($nextPosition->getLetter() === $wordArray[$currentIndex]) {
                $this->hasNextLetter($word, $currentIndex + 1, $nextPosition, $direction);
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

    public function getPosition(int $x, int $y): Position
    {
        foreach ($this->positions as $position) {
            if ($position->getX() === $x && $position->getY() === $y) {
                return $position;
            }
        }
        throw new \Exception("Position not found: $x, $y");
    }

    public function getMaxX(): int
    {
        return $this->maxX;
    }

    public function getMaxY(): int
    {
        return $this->maxY;
    }
}