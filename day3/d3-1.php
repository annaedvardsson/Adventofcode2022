<?php

$total = 0;

$file = fopen("d3_RucksackReorganization.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($file)) {

        $line = trim(fgets($file));
        $found = false;

        // step through characters in first half
        for ($i=0; $i < (strlen($line)/2) ; $i++) {
            if ($found) {
                break;
            }
                    
            // step through characters in second half (reverse)
            for ($j=strlen($line)-1; $j > (strlen($line)/2)-1; $j--) {
                if ($found) {
                    break;
                }

                // check if characters match
                if (strcmp($line[$i],$line[$j]) == 0) {
                    $value = ord($line[$i]);
                    if ($value >= 96) {
                        $value = $value - 96;
                    } else {
                        $value = $value - 38;
                    }
                    $total = $total + $value;
                    $found = true;
                }
            }
        }
    }
fclose($file);

echo 'Total points: ' .  $total;
