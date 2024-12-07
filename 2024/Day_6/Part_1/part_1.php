<?php

require_once 'Direction.php';
require_once 'DirectionManager.php';
require_once 'Grid.php';
require_once 'Guard.php';
require_once 'Position.php';

use Day_6\Part_1\DirectionManager;
use Day_6\Part_1\Grid;
use Day_6\Part_1\Guard;
use Day_6\Part_1\Position;

DirectionManager::init();

$input = __DIR__ . "/input.txt";

if (!file_exists($input)) {
    throw new \Exception("File not found: $input");
}

$content = file_get_contents($input);
$lines = explode("\n", $content);

$positions = [];
foreach ($lines as $y => $line) {
    $cases = str_split($line);
    foreach ($cases as $x => $case) {
        $position = new Position($x, $y, $case === '#');
        $positions[] = $position;
        if ("^" === $case) {
            $guard = new Guard($position, DirectionManager::getDirectionByName('up'));
        }
    }
}

if (!isset($guard)) {
    throw new \Exception("No guard found");
}

$grid = new Grid($positions);
$guard->useGrid($grid);

do {
    $guard->move();
} while (!$guard->isOutOrBlocked());

echo "Le garde a parcouru ".count($guard->getMemory())." blocs différents";