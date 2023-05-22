<?php

$trees = array();
$returns = array();
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

//Evaluate LEFT TO RIGHT
$returns = leftToRight($trees, $visibles, $total);
//Evaluate TOP TO BOTTOM
$returns = topToBottom($trees, $returns[0], $returns[1]);
//Evaluate RIGHT TO LEFT
$returns = rightToLeft($trees, $returns[0], $returns[1]);
//Evaluate BOTTOM TO TOP
$returns = bottomToTop($trees, $returns[0], $returns[1]);
$visibles = $returns[0];
$total = $returns[1];


// final answer
echo $total . " trees are visible from the outside\n";

// drawVisiblesMatrix($visibles);


// ***** FUNKTIONS *****
function leftToRight($trees, $visibles, $total)
{
    for ($i = 0; $i < ROWS; $i++) {
        $highestInRow = 0;
        for ($j = 0; $j < COLUMNS; $j++) {

            if ($i == 0 || $i == ROWS - 1 || $trees[$i][$j] > $highestInRow) {
                $highestInRow = $trees[$i][$j];
                $visibles[$i][$j] = true;
                $total++;
            } else {
                $visibles[$i][$j] = false;
            }
        }
    }            
    $returns = array($visibles, $total);
    return $returns;
}

function topToBottom($trees, $visibles, $total)
{
    for ($i = 0; $i < COLUMNS; $i++) {
        $highestInCol[$i] = 0;
    }

    for ($i = 0; $i < ROWS; $i++) {
        for ($j = 0; $j < COLUMNS; $j++) {

            if ($j == 0 || $j == COLUMNS - 1 || $trees[$i][$j] > $highestInCol[$j]) {
                $highestInCol[$j] = $trees[$i][$j];
                if ($visibles[$i][$j] == false) {
                    $visibles[$i][$j] = true;
                    $total++;
                }
            }
        }
    }
    $returns = array($visibles, $total);
    return $returns;
}

function rightToLeft($trees, $visibles, $total)
{
    for ($i = ROWS - 1; $i >= 0; $i--) {
        $highestInRow = 0;
        for ($j = COLUMNS - 1; $j >= 0; $j--) {

            if ($trees[$i][$j] > $highestInRow) {
                $highestInRow = $trees[$i][$j];
                if ($visibles[$i][$j] == false) {
                    $visibles[$i][$j] = true;
                    $total++;
                }
            }
        }
    }
    $returns = array($visibles, $total);
    return $returns;
}

function bottomToTop($trees, $visibles, $total)
{   
    for ($i = 0; $i < COLUMNS; $i++) {
        $highestInCol[$i] = 0;
    }

    for ($i = ROWS - 1; $i >= 0; $i--) {
        for ($j = COLUMNS - 1; $j >= 0; $j--) {

            if ($trees[$i][$j] > $highestInCol[$j]) {
                $highestInCol[$j] = $trees[$i][$j];
                if ($visibles[$i][$j] == false) {
                    $visibles[$i][$j] = true;
                    $total++;
                }
            }
        }
    }
    $returns = array($visibles, $total);
    return $returns;
}

function drawVisiblesMatrix($visibles) {
    for ($i = 0; $i < ROWS; $i++) {
        for ($j = 0; $j < COLUMNS; $j++) {
            if ($visibles[$i][$j] == true) {
                echo '1';
            } else {
                echo ' ';
            }
        }
        echo "\n";
    }
}