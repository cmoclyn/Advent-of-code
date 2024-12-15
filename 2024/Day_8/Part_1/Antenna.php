<?php

namespace Day_8\Part_1;

readonly class Antenna
{
    public function __construct(private string $frequency, private int $x, private int $y){}

    public function getFrequency(): string
    {
        return $this->frequency;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getAntinodeForAntenna(Antenna $antenna): Antenna
    {
        $deltaY = $this->getY() - $antenna->getY();
        $deltaX = $this->getX() - $antenna->getX();

        $newY = $this->getY() + $deltaY;
        $newX = $this->getX() + $deltaX;

        return new Antenna('#', $newX, $newY);
    }

    public function getPosition(): string
    {
        return "$this->x, $this->y";
    }

    public function __toString(): string
    {
        return "Antenne [$this->frequency] ({$this->getPosition()})";
    }

}