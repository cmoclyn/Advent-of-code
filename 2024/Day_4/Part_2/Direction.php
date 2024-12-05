<?php

namespace Day_4\Part_1;

readonly class Direction
{
    public function __construct(private int $diffX, private int $diffY) {}

    public function getNextPosition(Grid $grid, Position $position): Position
    {
        $nextX = $position->getX() + $this->diffX;
        $nextY = $position->getY() + $this->diffY;

        if ($nextX < 0 || $nextX >= $grid->getMaxX() || $nextY < 0 || $nextY >= $grid->getMaxY()) {
            throw new \Exception("Position not found: $nextX, $nextY");
        }

        return $grid->getPosition($nextX, $nextY);
    }

    public function getPreviousPosition(Grid $grid, Position $position): Position
    {
        $previousX = $position->getX() - $this->diffX;
        $previousY = $position->getY() - $this->diffY;

        if ($previousX < 0 || $previousX >= $grid->getMaxX() || $previousY < 0 || $previousY >= $grid->getMaxY()) {
            throw new \Exception("Position not found: $previousX, $previousY");
        }

        return $grid->getPosition($previousX, $previousY);
    }
}