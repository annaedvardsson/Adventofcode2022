<?php

$total = 0;

$file = fopen("d3_RucksackReorganization.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($file)) {
        // read three lines and sort by length
        $groups = array();
        for ($i=0; $i < 3; $i++) {
            $line = trim(fgets($file));
            $groups[] = $line;
        }
        usort($groups, 'sortByLength');

        // find character present in all three strings
        $found = false;
        for ($i=0; $i < strlen($groups[0]); $i++) {
            if ($found) {
                break;
            }
            
            $char = substr($groups[0], $i, 1);
            if (str_contains($groups[1], $char) && str_contains($groups[2], $char)) {
                $value = ord($char);
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
fclose($file);

echo 'Total points: ' .  $total;

// Functons
function sortByLength($a, $b)
{
    return strlen($a) - strlen($b);
}
