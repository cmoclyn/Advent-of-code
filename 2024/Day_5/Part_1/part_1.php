<?php

require_once 'Rule.php';
require_once 'RuleManager.php';
require_once 'UpdateManager.php';

use Day_5\Part_1\RuleManager;
use Day_5\Part_1\UpdateManager;

$pagesUpdates = __DIR__ ."/pages_updates.txt";
$rules = __DIR__ ."/rules.txt";

$ruleManager = RuleManager::loadFile($rules);
$updateManager = UpdateManager::loadFile($pagesUpdates, $ruleManager);
echo $updateManager->getResult();