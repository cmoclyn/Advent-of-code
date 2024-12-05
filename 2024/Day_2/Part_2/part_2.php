<?php

require_once 'Report.php';
require_once 'ReportManager.php';

use Day_2\Part_2\ReportManager;

$input = dirname(__FILE__)."/input.txt";

$reportManager = ReportManager::loadFile($input, 1, 3);
$reportManager->countSafe();