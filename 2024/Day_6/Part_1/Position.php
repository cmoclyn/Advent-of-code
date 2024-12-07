<?php

namespace Day_6\Part_1;

readonly class Position
{
    public function __construct(private int $x, private int $y, private bool $isBlock) {}

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function canPassOnIt(): bool
    {
        return !$this->isBlock;
    }

    public function getIdentifier(): string
    {
        return "[$this->x, $this->y]";
    }

    public function __toString(): string
    {
        return $this->getIdentifier();
    }
}