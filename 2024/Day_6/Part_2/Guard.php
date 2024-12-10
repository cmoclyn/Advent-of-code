<?php

namespace Day_6\Part_2;

class Guard
{
    private readonly Grid $grid;

    private Position $position;
    private Direction $direction;

    private Memory $memory;

    private bool $isOut = false;

    private bool $isBlocked = false;

    public function __construct(private readonly Position $defaultPosition, private Direction $defaultDirection)
    {
        $this->position = $this->defaultPosition;
        $this->direction = $this->defaultDirection;
        $this->memory = new Memory();
    }

    public function useGrid(Grid $grid): void
    {
        $this->grid = $grid;
    }

    public function isOut(): bool
    {
        return $this->isOut;
    }

    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    public function isOutOrBlocked(): bool
    {
        return $this->isOut || $this->isBlocked;
    }

    public function move(): void
    {
        $nextPosition = $this->grid->getNextPosition($this->position, $this->direction);
        if (null === $nextPosition) {
            $this->isOut = true;
//            echo "Je suis sorti\n";
            return;
        }

        if (!$nextPosition->canPassOnIt()) {
            $this->turn();
//            echo "$this->position Je tourne\n";
            return;
        }

//        echo "$this->position J'avance $nextPosition\n";
        if ($this->memory->isNewDirectionForPosition($nextPosition, $this->direction)) {
            $this->memory->addPosition($nextPosition, $this->direction);
            $this->position = $nextPosition;
            return;
        }
        echo "Bloqué !!!";
        $this->isBlocked = true;
    }

    public function turn(): void
    {
        $nexDirection = DirectionManager::getNextDirection($this->direction);
        $this->direction = $nexDirection;
    }

    public function getMemory(): Memory
    {
        return $this->memory;
    }

    public function resetPosition(): void
    {
        $this->position = $this->defaultPosition;
        $this->direction = $this->defaultDirection;
        $this->isOut = false;
        $this->isBlocked = false;
        $this->memory = new Memory();
    }
}