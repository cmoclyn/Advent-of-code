<?php

namespace Day_1\Part_1;

readonly class ListManager
{
    public function __construct(private ListNumbers $firstList, private ListNumbers $secondList){}

    public function countDistance(): void
    {
        $totalDistance = 0;
        for($i = 0; $i < $this->firstList->count(); $i++) {
            $elementFromFirstList = $this->firstList->get($i);
            $elementFromSecondList = $this->secondList->get($i);
            $distance = abs($elementFromFirstList - $elementFromSecondList);
            $totalDistance += $distance;
            $this->output("Distance between $elementFromFirstList and $elementFromSecondList => $distance");
        }
        $this->output("Total distance => $totalDistance");
    }

    private function output(mixed $data): void
    {
        echo "$data\n";
    }
}
