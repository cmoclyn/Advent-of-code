<?php

namespace Day_6\Part_2;

class Grid
{
    /**
     * @param Position[] $positions
     */
    public function __construct(private readonly array $positions) {}

    public function getNextPosition(Position $position, Direction $direction): ?Position
    {
        $x = $position->getX();
        $y = $position->getY();

        $nextX = $x + $direction->getXChange();
        $nextY = $y + $direction->getYChange();

        foreach ($this->positions as $currentPosition) {
            if ($currentPosition->getX() === $nextX && $currentPosition->getY() === $nextY) {
                return $currentPosition;
            }
        }
        return null;
    }

    public function getPositionByIdentifier(string $identifier): Position
    {
        foreach ($this->positions as $position) {
            if ($position->getIdentifier() === $identifier) {
                return $position;
            }
        }
        throw new \Exception("Position $identifier not found");
    }

    public function getPositions(): array
    {
        return $this->positions;
    }
}