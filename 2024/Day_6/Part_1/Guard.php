<?php

namespace Day_6\Part_1;

class Guard
{
    private Grid $grid;

    private array $memory;

    private bool $isOut = false;

    public function __construct(private Position $position, private Direction $direction) {}

    public function useGrid(Grid $grid): void
    {
        $this->grid = $grid;
    }

    public function isOutOrBlocked(): bool
    {
        return $this->isOut;
    }

    public function move(): void
    {
        $nextPosition = $this->grid->getNextPosition($this->position, $this->direction);
        if (null === $nextPosition) {
            $this->isOut = true;
            echo "Je suis sorti\n";
            return;
        }

        if (!$nextPosition->canPassOnIt()) {
            $this->turn();
            echo "$this->position Je tourne\n";
            return;
        }

        echo "$this->position J'avance $nextPosition\n";
        $this->position = $nextPosition;
        if ($this->alreadyPassPositionInThisDirection()) {
            $this->isOut = true;
            echo "Je suis bloqué\n";
            return;
        }

        $this->memory[$this->position->getIdentifier()][] = $this->direction;
    }

    public function alreadyPassPositionInThisDirection(): bool
    {
        if (!isset($this->memory[$this->position->getIdentifier()])) {
            return false;
        }

        foreach ($this->memory[$this->position->getIdentifier()] as $directions) {
            foreach ($directions as $direction) {
                if ($direction === $this->direction) {
                    echo "$this->position Je suis déjà passé par ici mais pas dans ce sens\n";
                    return true;
                }
            }
        }
        return false;
    }

    public function turn(): void
    {
        $nexDirection = DirectionManager::getNextDirection($this->direction);
        $this->direction = $nexDirection;
    }

    public function getMemory(): array
    {
        return $this->memory;
    }
}