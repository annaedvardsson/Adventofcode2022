<?php

$total = 0;
define('WIN', 6);
define('DRAW', 3);
define('ROCK', 1);
define('PAPER', 2);
define('SCISSORS', 3);


$file = fopen("d2_RockPaperScissors.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($file)) {
        $currentRound = trim(fgets($file));

        switch ($currentRound) {
            case 'A X':
                $total = $total + SCISSORS;
                break;
            case 'A Y':
                $total = $total + DRAW + ROCK;
                break;
            case 'A Z':
                $total = $total + WIN + PAPER;
                break;
            case 'B X':
                $total = $total + ROCK;
                break;
            case 'B Y':
                $total = $total + DRAW + PAPER;
                break;
            case 'B Z':
                $total = $total + WIN + SCISSORS;
                break;
            case 'C X':
                $total = $total + PAPER;
                break;
            case 'C Y':
                $total = $total + DRAW + SCISSORS;
                break;
            case 'C Z':
                $total = $total + WIN + ROCK;
                break;
        }
    }
fclose($file);

echo 'Total points: ' .  $total;