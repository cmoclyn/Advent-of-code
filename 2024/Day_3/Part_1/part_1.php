<?php


$input = dirname(__FILE__) . "/input.txt";

$content = file_get_contents($input);
preg_match_all('/mul\((\d+),(\d+)\)/', $content, $matches);

$sum = 0;
for ($i = 0; $i < count($matches[1]); $i++) {
    $sum += ($matches[1][$i] * $matches[2][$i]);
}
echo $sum;