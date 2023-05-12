<?php

define('MARKERLENGTH', 4); //Part 1: 4, part 2: 14

// $file = fopen("d6_Example.txt", "r") or die("Unable to open file!");
$file = fopen("d6_TuningTrouble.txt", "r") or die("Unable to open file!");

// read file line-by-line until end-of-file
while (!feof($file)) {

    $line = trim(fgets($file));

    for ($i=0; $i < (strlen($line) - MARKERLENGTH + 1); $i++) { 
        // get unique charachters in substring (length = UNIQUELENGTH) 
        $uniques = array_unique(str_split(substr($line, $i, MARKERLENGTH)));
        
        if (count($uniques) == MARKERLENGTH) {
            echo 'Marker appear after character: ' . $i+ MARKERLENGTH;
            break;
        }
        if ($i == strlen($line) - MARKERLENGTH) {
            echo 'No marker in this sequence!';
        }
    }
    echo "\n";
}

fclose($file);


