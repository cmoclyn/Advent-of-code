<?php

require_once 'ListManager.php';
require_once 'ListNumbers.php';

use Day_1\Part_2\ListManager;
use Day_1\Part_2\ListNumbers;

$firstFile = dirname(__FILE__)."/input_first_list.txt";
$secondFile = dirname(__FILE__)."/input_second_list.txt";

$firstList = ListNumbers::loadFile($firstFile);
$secondList = ListNumbers::loadFile($secondFile);

$listManager = new ListManager($firstList, $secondList);
$listManager->countSimilarity();