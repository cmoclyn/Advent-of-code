<?php

require_once  __DIR__.'/Antenna.php';
require_once  __DIR__.'/AntennaManager.php';

use Day_8\Part_2\AntennaManager;

$input = dirname(__DIR__) . "/input.txt";


$manager = AntennaManager::init($input);
$antinodes = $manager->getAntinodes();

$nbAntinodes = count($antinodes);

echo "$nbAntinodes antinodes trouvées\n";