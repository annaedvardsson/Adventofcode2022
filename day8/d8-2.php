<?php

$trees = array();
$visibles = array();
$highestInCol = array();
$topScenicScore = array(0, 0, 0);
$total;

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

// check scenic score for all trees
for ($i = 0; $i < ROWS; $i++) {
    for ($j = 0; $j < COLUMNS; $j++) {

        $total = 1;
        $total = lookRight($trees, $total, $i, $j, $trees[$i][$j]);
        $total = lookDown($trees, $total, $i, $j, $trees[$i][$j]);
        $total = lookLeft($trees, $total, $i, $j, $trees[$i][$j]);
        $total = lookUp($trees, $total, $i, $j, $trees[$i][$j]);

        if ($total > $topScenicScore[2]) {
            unset($topScenicScore);
            $topScenicScore = array($i, $j, $total);
        }
    }
}

// final answer
echo 'The tree at position [' . $topScenicScore[0] . '][' . $topScenicScore[1] . '] has the best scenic score: ' . $topScenicScore[2] . "\n";


// ***** FUNKTIONS *****
function lookRight($trees, $total, $currentRow, $currentCol, $currentTree)
{
    $distance = 0;
    for ($j = $currentCol+1; $j < COLUMNS; $j++) {
        $distance++;
        if ($trees[$currentRow][$j] >= $currentTree) {
            break;
        }
    }

    $total *= $distance;
    return $total;
}

function lookDown($trees, $total, $currentRow, $currentCol, $currentTree)
{
    $distance = 0;
    for ($i = $currentRow+1; $i < ROWS; $i++) {
        $distance++;
        if ($trees[$i][$currentCol] >= $currentTree) {
            break;
        }
    }

    $total *= $distance;
    return $total;
}

function lookLeft($trees, $total, $currentRow, $currentCol, $currentTree)
{
    $distance = 0;
    for ($j = $currentCol-1; $j >= 0; $j--) {
        $distance++;
        if ($trees[$currentRow][$j] >= $currentTree) {
            break;
        }
    }
    $total *= $distance;
    return $total;
}

function lookUp($trees, $total, $currentRow, $currentCol, $currentTree)
{
    $distance = 0;
    for ($i = $currentRow-1; $i >= 0; $i--) {
        $distance++;
        if ($trees[$i][$currentCol] >= $currentTree) {
            break;
        }
    }
    $total *= $distance;
    return $total;
}