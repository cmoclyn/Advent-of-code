<?php

namespace Day_6\Part_2;

class Memory
{
    private array $positions = [];

    public function addPosition(Position $position, Direction $direction): void
    {
        $this->positions[$position->getIdentifier()][] = $direction;
    }

    public function isNewPosition(Position $position): bool
    {
        return !array_key_exists($position->getIdentifier(), $this->positions);
    }

    public function isNewDirectionForPosition(Position $position, Direction $direction): bool
    {
        if ($this->isNewPosition($position)) {
            return true;
        }

        foreach ($this->positions[$position->getIdentifier()] as $memoryDirection) {
            if ($memoryDirection->getName() === $direction->getName()) {
//                echo "$this->position Je suis déjà passé par ici dans ce sens\n";
                return false;
            }
        }
        return true;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function debug(): void
    {
        $positionsByDirections = [];
        foreach ($this->positions as $positionIdentifier => $directions) {
            $directionsNames = [];
            foreach ($directions as $direction) {
                $directionsNames[] = $direction->getName();
            }
            $positionsByDirections[count($directions)][$positionIdentifier] = implode(', ', $directionsNames);
        }

        foreach ($positionsByDirections as $nb => $positionIdentifiers) {
            foreach ($positionIdentifiers as $positionIdentifier => $directionsNames) {
                echo "$nb passages aux coordonnées $positionIdentifier. ($directionsNames) \n";
            }
        }
    }

    public function getNbPositions(): int
    {
        return count($this->positions);
    }
}