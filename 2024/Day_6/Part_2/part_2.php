<?php

require_once 'Direction.php';
require_once 'DirectionManager.php';
require_once 'Grid.php';
require_once 'Guard.php';
require_once 'Memory.php';
require_once 'Position.php';

use Day_6\Part_2\DirectionManager;
use Day_6\Part_2\Grid;
use Day_6\Part_2\Guard;
use Day_6\Part_2\Position;

DirectionManager::init();

$input = __DIR__ . "/input.txt";

if (!file_exists($input)) {
    throw new \Exception("File not found: $input");
}

$content = file_get_contents($input);
$lines = explode("\n", $content);

$defaultGuardPosition = null;
$positions = [];
foreach ($lines as $y => $line) {
    $cases = str_split($line);
    foreach ($cases as $x => $case) {
        $position = new Position($x, $y, $case === '#');
        $positions[] = $position;
        if ("^" === $case) {
            $defaultGuardPosition = $position;
        }
    }
}

if (null === $defaultGuardPosition) {
    throw new \Exception("No guard found");
}

$grid = new Grid($positions);
$guard = new Guard($defaultGuardPosition, DirectionManager::getDirectionByName('up'));
$guard->useGrid($grid);

// Chemin normal
do {
    $guard->move();
} while (!$guard->isOutOrBlocked());

$originalMemory = $guard->getMemory();
$nbPositionsInOriginal = $originalMemory->getNbPositions();
echo "Il y a $nbPositionsInOriginal positions dans le chemin original\n";

//$originalMemory->debug();

$positionsAlreadyBlocked = [];
$numberOfBlockedPath = 0;
$currentBlocIndex = 0;
foreach ($originalMemory->getPositions() as $positionIdentifier => $directions) {
    $percent = round($currentBlocIndex / $nbPositionsInOriginal * 100, 2);
    echo "Blocage #$currentBlocIndex / $nbPositionsInOriginal ($percent %)";
    $currentBlocIndex++;

    if($positionIdentifier === $defaultGuardPosition->getIdentifier() || in_array($positionIdentifier, $positionsAlreadyBlocked, true)) {
        continue;
    }
//            echo "Blocage #".(count($positionsAlreadyBlocked) + 1)."\n";
    $position = $grid->getPositionByIdentifier($positionIdentifier);
    $position->changeToBlock();
    $positionsAlreadyBlocked[] = $positionIdentifier;

    $guard->resetPosition();
    do {
        $guard->move();
    } while (!$guard->isOutOrBlocked());

    if ($guard->isBlocked()) {
        echo " - Blocage en $position";
        $numberOfBlockedPath++;
    }
    echo "\n";
    $position->restoreDefaultType();
}

echo "Il y a $numberOfBlockedPath configuration dans laquelle le garde s'est retrouvé bloqué\n";
// 194 pas bon, trop bas
// 1706 pas bon, trop haut