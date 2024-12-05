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
        $possibleDirections = [-1, 1];
        foreach ($possibleDirections as $directionY) {
            foreach ($possibleDirections as $directionX) {
                $this->directions[] = new Direction($directionX, $directionY);
            }
        }
    }

    public function countWord(string $word): int
    {
        $middleLetterIndex = 1;
        $middleLetter = $word[$middleLetterIndex];
        $this->count = 0;

        foreach ($this->positions as $position) {
            if ($middleLetter === $position->getLetter()) {
                $currentMatch = 0;
                foreach ($this->directions as $direction) {
                    try {
                        $previousPosition = $direction->getPreviousPosition($this, $position);
                        $nextPosition = $direction->getNextPosition($this, $position);
                    } catch (\Exception $e) {
                        continue 2;
                    }

                    if ($previousPosition->getLetter() === $word[$middleLetterIndex - 1] && $nextPosition->getLetter(
                        ) === $word[$middleLetterIndex + 1]) {
                        $currentMatch++;
                    }
                }
                if ($currentMatch === 2) {
                    $this->count++;
                }
            }
        }
        return $this->count;
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