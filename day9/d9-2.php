<?php

// set row and column constants (d9_Example2.txt = 5,6; d9_Example2.txt = 21,26; d9_RopeBridge.txt = 250,450)
define('ROWS', 250);
define('COLUMNS', 450);
// set start position constants (d9_Example2.txt = 4,0; d9_Example2.txt = 15,11; d9_RopeBridge.txt = 60,10)
define('ROWSTART', 60);
define('COLUMNSTART', 10);
// set number of knots (length)
define('KNOTS', 10);

$visited = array_fill(0, KNOTS, array_fill(0, ROWS, array_fill(0, COLUMNS, false)));
$positions = array_fill(0, KNOTS, array_fill(0, 2, 0));
$positionsMax = array(PHP_INT_MIN, PHP_INT_MIN);
$positionsMin = array(PHP_INT_MAX, PHP_INT_MAX);
$moves = array();
$total = 1;


//Read input to array
// $inputFile = fopen("d9_Example.txt", "r") or die("Unable to open file!");
// $inputFile = fopen("d9_Example2.txt", "r") or die("Unable to open file!");
$inputFile = fopen("d9_RopeBridge.txt", "r") or die("Unable to open file!");

    while (!feof($inputFile)) {
        $line = trim(fgets($inputFile));
        $moves[] = explode(" ", $line);
    }

fclose($inputFile);


// set start values
for ($i=0; $i < KNOTS; $i++) {
    $positions[$i][0] = ROWSTART;
    $positions[$i][1] = COLUMNSTART;
    $visited[$i][ROWSTART][COLUMNSTART] = true;
}


// Execute input, line by line
for ($i=0; $i < count($moves); $i++) {
    //Execute line repeats
    for ($j=0; $j < $moves[$i][1]; $j++) { 
        // move head and mark unique positions
        $positions = moveHead($moves[$i][0], $positions);
        $visited[0][$positions[0][0]][$positions[0][1]] = true;
        
        // move all knots and mark unique position of each
        for ($k=1; $k < KNOTS; $k++) { 
            $positions = moveKnots($positions, $k);
            // count unique tail positions (last knot)
            if ($k == KNOTS-1) {
                if ($visited[$k][$positions[KNOTS - 1][0]][$positions[KNOTS - 1][1]] == false) {
                    $total++;
                }
            }
            $visited[$k][$positions[$k][0]][$positions[$k][1]] = true;
        }
    }
}

// final answer
echo $total . " unique tail positions\n";


// ***** FUNKTIONS *****
function moveHead($move, $positions) {
    switch ($move) {
        case 'U':
            $positions[0][0] += -1;
            break;
        case 'D':
            $positions[0][0] += 1;
            break;
        case 'L':
            $positions[0][1] += -1;
            break;
        case 'R':
            $positions[0][1] += 1;
            break;
        default:
            break;
    }

    return $positions;
}

function moveKnots($positions, $k) {
    // previous moved right
    if ($positions[$k][1] < $positions[$k-1][1] - 1) {
        $positions[$k][1] += 1;
        if ($positions[$k][0] < $positions[$k - 1][0]) {
            $positions[$k][0] += 1;
        }
        if ($positions[$k][0] > $positions[$k - 1][0]) {
            $positions[$k][0] += -1;
        }
    // previous moved left
    } elseif ($positions[$k][1] > $positions[$k-1][1] + 1) {
        $positions[$k][1] += -1;
        if ($positions[$k][0] < $positions[$k - 1][0]) {
            $positions[$k][0] += 1;
        }
        if ($positions[$k][0] > $positions[$k - 1][0]) {
            $positions[$k][0] += -1;
        }
    // previous moved down
    } elseif ($positions[$k][0] < $positions[$k-1][0] - 1) {
        $positions[$k][0] += 1;
        if ($positions[$k][1] < $positions[$k - 1][1]) {
            $positions[$k][1] += 1;
        }
        if ($positions[$k][1] > $positions[$k - 1][1]) {
            $positions[$k][1] += -1;
        }
    // previous moved up
    } elseif ($positions[$k][0] > $positions[$k-1][0] + 1) {
        $positions[$k][0] += -1;
        if ($positions[$k][1] < $positions[$k - 1][1]) {
            $positions[$k][1] += 1;
        }
        if ($positions[$k][1] > $positions[$k - 1][1]) {
            $positions[$k][1] += -1;
        }
    }
    return $positions;
}


//***** SUPPORT FUNCTIONS (DEVELOPMENT) *****
function drawPositions($positions) {
    for ($i = 0; $i < ROWS; $i++) {
        for ($j = 0; $j < COLUMNS; $j++) {
            $x='.';
            for ($w=9; $w >=0 ; $w--) {
                if ($positions[$w][0] == $i && $positions[$w][1] == $j) {
                    $x = $w;
                } 
            }
            if (is_numeric($x)) {
                echo $x;
            } else {
                echo '.';
            }
        }
        echo "\n";
    }
    echo "\n";
}

function drawVisitedMatrix($visitedHead, $indicator) {
    for ($i = 0; $i < ROWS; $i++) {
        for ($j = 0; $j < COLUMNS; $j++) {
            if ($visitedHead[$indicator][$i][$j] == true) {
                echo $indicator;
            } else {
                echo '.';
            }
        }
        echo "\n";
    }
    echo "\n";
}

function findPositionsMax($positions, $positionsMax) {
    if ($positionsMax[0] < $positions[0][0]) {
        $positionsMax[0] = $positions[0][0];
    } elseif ($positionsMax[1] < $positions[0][1]) {
        $positionsMax[1] = $positions[0][1];
    }
    return $positionsMax;
}

function findPositionsMin($positions, $positionsMin) {
    if ($positionsMin[0] > $positions[0][0]) {
        $positionsMin[0] = $positions[0][0];
    } elseif ($positionsMin[1] > $positions[0][1]) {
        $positionsMin[1] = $positions[0][1];
    }
    return $positionsMin;
}

