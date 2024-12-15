<?php

namespace Day_8\Part_2;

readonly class Antenna
{
    public function __construct(private string $frequency, private int $x, private int $y) {}

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

    /**
     * @return Antenna[]
     */
    public function getAntinodesForAntenna(Antenna $antenna, int $xMax, int $yMax): array
    {
        $deltaY = $this->getY() - $antenna->getY();
        $deltaX = $this->getX() - $antenna->getX();

        $antennas = [];
        $i = 1;
        do {
            $newY = $this->getY() + ($deltaY * $i);
            $newX = $this->getX() + ($deltaX * $i);
            if(0 > $newX || $newX > $xMax || 0 > $newY || $newY > $yMax){
                break;
            }
            $antennas[] = new Antenna('#', $newX, $newY);

            $i++;
        } while (true);

        return $antennas;
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