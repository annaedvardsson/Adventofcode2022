<?php

$total = 0;

$file = fopen("d4_CampCleanup.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($file)) {

        unset($values);

        // read line, get start and end points
        $line = trim(fgets($file));
        preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', $line, $values);

        // check if first section is enclosed in the second section, or vice versa
        if (($values[1] >= $values[3] && $values[2] <= $values[4]) || 
            ($values[1] <= $values[3] && $values[2] >= $values[4])) 
        {
            $total++;
        }
    }

fclose($file);

echo 'Total points: ' .  $total;
