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


for ($i=0; $i < count($moves); $i++) { 
    $step = instructionToSteps($moves[$i][0]);
    for ($j=0; $j < $step; $j++) { 
        $cycle++;
        if (($cycle+20) % 40 == 0) {
            $signalStrengths[] = $cycle * $registerValue;
            echo 'Signal strength ' . end($signalStrengths) . "\n";
        }
    }
    if (!empty($moves[$i][1])) {
        $registerValue += (int)$moves[$i][1];
    }
}

echo 'Sum of signal strengths is: ' . array_sum($signalStrengths);


// ***** FUNCTIONS *****
function instructionToSteps($instruction) {
    if ($instruction == 'noop') {
        return 1;
    } else {
        return 2;
    }
}
