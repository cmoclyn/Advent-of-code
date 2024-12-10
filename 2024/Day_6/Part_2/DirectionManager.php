<?php

namespace Day_6\Part_2;

class DirectionManager
{
    /** @var Direction[] $directions */
    private static array $directions;

    public static function init(): void
    {
        self::$directions = [
            new Direction('up', 0, -1),
            new Direction('right', 1, 0),
            new Direction('down', 0, 1),
            new Direction('left', -1, 0),
        ];
    }

    public static function getDirectionByName(string $directionName): Direction
    {
        foreach (self::$directions as $direction) {
            if ($direction->getName() === $directionName) {
                return $direction;
            }
        }
        throw new \Exception("Direction $directionName does not exist");
    }

    public static function getNextDirection(Direction $direction): Direction
    {
        $index = self::findIndexPosition($direction);
        $index++;
        if (count(self::$directions) === $index) {
            $index = 0;
        }
        return self::$directions[$index];
    }

    private static function findIndexPosition(Direction $direction): int
    {
        foreach (self::$directions as $index => $currentDirection) {
            if ($currentDirection === $direction) {
                return $index;
            }
        }
        throw new \Exception("Direction '{$direction}' not found");
    }
}