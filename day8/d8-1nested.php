<?php

$trees = array();
$visibles = array();
$highestInCol = array();
$total = 0;

// $inputFile = fopen("d8_Example.txt", "r") or die("Unable to open file!");
$inputFile = fopen("d8_TreetopTreeHouse.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($inputFile)) {
        $line = trim(fgets($inputFile));
        $trees[] = str_split($line);
    }

fclose($inputFile);

// set row and column constants
define('ROWS', count($trees));
define('COLUMNS', count($trees[0]));

//Evaluate LEFT TO RIGHT and TOP TO BOTTOM
for ($i = 0; $i < COLUMNS; $i++) {
    $highestInCol[$i] = 0;
}

for ($i = 0; $i < ROWS; $i++) {
    $highestInRow = 0;
    for ($j = 0; $j < COLUMNS; $j++) {

        if ($i == 0 || $i == ROWS - 1 || $j == 0 || $j == COLUMNS - 1 || $highestInRow < $trees[$i][$j] || $highestInCol[$j] < $trees[$i][$j]) {

            if ($highestInRow < $trees[$i][$j]) {
                $highestInRow = $trees[$i][$j];
            }
            if ($highestInCol[$j] < $trees[$i][$j]) {
                $highestInCol[$j] = $trees[$i][$j];
            }

            $visibles[$i][$j] = true;
            $total++;
        } else {
            $visibles[$i][$j] = false;
        }
    }
}

//Evaluate RIGHT TO LEFT and BOTTOM TO TOP
for ($i = 0; $i < COLUMNS; $i++) {
    $highestInCol[$i] = 0;
}

for ($i = ROWS-1; $i >=0; $i--) {
    $highestInRow = 0;
    for ($j = COLUMNS-1; $j >=0; $j--) {

        if ($highestInRow < $trees[$i][$j] || $highestInCol[$j] < $trees[$i][$j]) {

            if ($highestInRow < $trees[$i][$j]) {
                $highestInRow = $trees[$i][$j];
            }
            if ($highestInCol[$j] < $trees[$i][$j]) {
                $highestInCol[$j] = $trees[$i][$j];
            }

            if ($visibles[$i][$j] == false) {
                $visibles[$i][$j] = true;
                $total++;
            }
        }
    }
}

// final answer
echo $total . " trees are visible from the outside\n";