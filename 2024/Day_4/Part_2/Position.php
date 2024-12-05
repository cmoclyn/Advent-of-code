<?php

namespace Day_4\Part_1;

readonly class Position
{
    public function __construct(private int $x, private int $y, private string $letter){}

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getLetter(): string
    {
        return $this->letter;
    }

    public function __toString(): string
    {
        return "[$this->x][$this->y] $this->letter ";
    }
}