<?php

namespace Day_6\Part_2;

readonly class Direction
{
    public function __construct(private string $name, private int $xChange, private int $yChange){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getXChange(): int
    {
        return $this->xChange;
    }

    public function getYChange(): int
    {
        return $this->yChange;
    }

    public function __toString(): string
    {
        return "[$this->name]";
    }
}