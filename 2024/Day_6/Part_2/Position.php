<?php

namespace Day_6\Part_2;

class Position
{
    private bool $temporaryBlock = false;

    public function __construct(private readonly int $x, private readonly int $y, private readonly bool $isBlock) {}

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
        if ($this->temporaryBlock) {
            return false;
        }
        return !$this->isBlock;
    }

    public function changeToBlock(): void
    {
//        echo "La position $this est devenu un bloc\n";
        $this->temporaryBlock = true;
    }

    public function restoreDefaultType(): void
    {
        $this->temporaryBlock = false;
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