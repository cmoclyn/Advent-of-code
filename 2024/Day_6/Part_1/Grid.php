<?php

namespace Day_6\Part_1;

readonly class Grid
{
    /**
     * @param Position[] $positions
     */
    public function __construct(private array $positions) {}

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
}