<?php

require_once  __DIR__.'/Calculator.php';

use Day_7\Part_1\Calculator;

$input = dirname(__DIR__) . "/input.txt";

if (!file_exists($input)) {
    throw new \Exception("File not found: $input");
}

$content = file_get_contents($input);
$lines = explode("\n", $content);

$calibration = 0;
foreach ($lines as $line) {
    $calculator = new Calculator($line);

    if($calculator->hasGoodCombinaisons()){
        $calibration += $calculator->getExpectedResult();
    }
}

echo "Calibration : $calibration\n";