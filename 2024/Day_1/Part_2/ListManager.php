<?php

namespace Day_1\Part_2;

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

    public function countSimilarity(): void
    {
        $totalSimilarity = 0;
        for($i = 0; $i < $this->firstList->count(); $i++) {
            $elementFromFirstList = $this->firstList->get($i);
            $quantityInSecondList = $this->secondList->howMany($elementFromFirstList);
            $similarity = $elementFromFirstList * $quantityInSecondList;
            $totalSimilarity += $similarity;
            $this->output("$elementFromFirstList is present $quantityInSecondList in second list, similarity => $similarity");
        }
        $this->output("Total similarity => $totalSimilarity");
    }

    private function output(mixed $data): void
    {
        echo "$data\n";
    }
}
