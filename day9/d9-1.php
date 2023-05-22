<?php

// set row and column constants (d9_Example2.txt = 5,6; d9_RopeBridge.txt = 250,450)
define('ROWS', 250);
define('COLUMNS', 450);
// set start position constants (d9_Example2.txt = 4,0; d9_RopeBridge.txt = 60,10)
define('ROWSTART', 60);
define('COLUMNSTART', 10);

$visitedHead = array_fill(0, ROWS, array_fill(0, COLUMNS, false));
$visitedTail = array_fill(0, ROWS, array_fill(0, COLUMNS, false));
$positionsMax = array(PHP_INT_MIN, PHP_INT_MIN);
$positionsMin = array(PHP_INT_MAX, PHP_INT_MAX);
$positions = array_fill(0, 2, array_fill(0, 2, 0));
$moves = array();
$total = 1;

//Read input to array
// $inputFile = fopen("d9_Example.txt", "r") or die("Unable to open file!");
$inputFile = fopen("d9_RopeBridge.txt", "r") or die("Unable to open file!");

    while (!feof($inputFile)) {
        $line = trim(fgets($inputFile));
        $moves[] = explode(" ", $line);
    }

fclose($inputFile);

// set start values
for ($i = 0; $i < 2; $i++) {
    $positions[$i][0] = ROWSTART;
    $positions[$i][1] = COLUMNSTART;
}
$visitedHead[$positions[0][0]][$positions[0][1]] = true;
$visitedTail[$positions[1][0]][$positions[1][1]] = true;


// Execute input, line by line
for ($i=0; $i < count($moves); $i++) {
    //Execute move X times
    for ($j=0; $j < $moves[$i][1]; $j++) { 
        // move head and mark unique positions
        $positions = moveHead($moves[$i][0], $positions);
        $visitedHead[$positions[0][0]][$positions[0][1]] = true;

        // move tail and mark unique positions
        $positions = moveTail($positions);
        if ($visitedTail[$positions[1][0]][$positions[1][1]] == false) {
            $visitedTail[$positions[1][0]][$positions[1][1]] = true;
            $total++;
        }
        // // find max/min head positions
        // $positionsMax = findPositionsMax($positions, $positionsMax);
        // $positionsMin = findPositionsMin($positions, $positionsMin);
    }
}

// final answer
echo $total . " unique tail positions\n";

// drawVisitedMatrix($visitedHead, $indicator='H');
// echo "**********\n";
// drawVisitedMatrix($visitedTail, $indicator='T');

// // display max/min head positions
// var_dump($positionsMax);
// var_dump($positionsMin);


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

function moveTail($positions) {
    // head moved right
    if ($positions[1][1] < $positions[0][1]-1) {
        $positions[1][1] += 1;
        $positions[1][0] = $positions[0][0];
        // head moved left
    } elseif ($positions[1][1] > $positions[0][1] + 1) {
        $positions[1][1] += -1;
        $positions[1][0] = $positions[0][0];
        // head moved down
    } elseif ($positions[1][0] < $positions[0][0]-1) {
        $positions[1][0] += 1;
        $positions[1][1] = $positions[0][1];
        // head moved up
    } elseif ($positions[1][0] > $positions[0][0]+1) {
        $positions[1][0] += -1;
        $positions[1][1] = $positions[0][1];
    }
    return $positions;
}


//***** ADDITIONAL TEST FUNCTIONS*****
function drawVisitedMatrix($visitedHead, $indicator) {
    for ($i = 0; $i < ROWS; $i++) {
        for ($j = 0; $j < COLUMNS; $j++) {
            if ($visitedHead[$i][$j] == true) {
            // if ($visitedHead[$indicator][$i][$j] == true) {
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








//************** Read variants *******************/
// echo "***** file_get_contents\n";
// $moves_fgc = array();
// $inputFile = file_get_contents("d9_Example.txt") or die("Unable to open file!");
// $moves_fgc[] = explode(PHP_EOL, $inputFile);
// var_dump($inputFile);
// var_dump($moves_fgc);

// echo "***** file\n";
// $moves_f = array();
// $inputFile = file("d9_Example.txt") or die("Unable to open file!");
// var_dump($inputFile);

// echo "***** fopen/fclose\n";
