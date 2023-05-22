<?php

//Read input to array
// $inputFile = fopen("d10_Example.txt", "r") or die("Unable to open file!");
$inputFile = fopen("d10_Cathode-RayTube.txt", "r") or die("Unable to open file!");

    while (!feof($inputFile)) {
        $line = trim(fgets($inputFile));
        $moves[] = explode(" ", $line);
    }

fclose($inputFile);


$cycle = 0;
$registerValue = 1;
$spritePositions = array(0,1,2);


for ($i=0; $i < count($moves); $i++) { 
    $step = instructionToSteps($moves[$i][0]);
    for ($j=0; $j < $step; $j++) { 
        // lit (#) if within sprite, else dark (.)
        if ($cycle >= $registerValue - 1 && $cycle <= $registerValue + 1) {
            echo '#';
        } else {
            echo '.';
        }
        
        $cycle++;
        if (($cycle) % 40 == 0) {
            echo "\n";
            $cycle = 0;
        }
    }
    if (!empty($moves[$i][1])) {
        $registerValue += (int)$moves[$i][1];
    }
}


// ***** FUNCTIONS *****
function instructionToSteps($instruction) {
    if ($instruction == 'noop') {
        return 1;
    } else {
        return 2;
    }
}
