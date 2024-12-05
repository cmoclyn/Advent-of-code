<?php

require_once 'Grid.php';
require_once 'Direction.php';
require_once 'Position.php';

use Day_4\Part_1\Grid;

$input = dirname(__FILE__)."/input.txt";

$grid = Grid::loadFile($input,);
echo $grid->countWord('MAS');