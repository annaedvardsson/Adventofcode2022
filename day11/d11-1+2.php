<?php

include_once 'd11-Monkey.php';


define('ROUNDS', 10000); //20 for part 1, 10000 for part 2

$part = 2;  //set to 1 or 2 depending on which part of the challengen to solve (see monkeyAction())
$lines = array();
$monkeyValues = array();


// $fileName = "d11_Example.txt";
$fileName = "d11_MonkeyInTheMiddle.txt";

//Read input to array
$inputFile = fopen($fileName, "r") or die("Unable to open file!");

    while (!feof($inputFile)) {
        $line = trim(fgets($inputFile));
        $monkeyValues = getMonkeyValues($line, $monkeyValues);
    }

fclose($inputFile);

// create Monkey objects and set properties
while (count($monkeyValues) > 0) {
    $monkies[] = new Monkey($monkeyValues[0], $monkeyValues[1], $monkeyValues[2][0], $monkeyValues[2][1], $monkeyValues[3], $monkeyValues[4], $monkeyValues[5]);
    $monkeyValues = array_slice($monkeyValues, 6);
}

// START ROUNDS
// repeat ROUNDS times
for ($i=0; $i < ROUNDS; $i++) { 
    // repeat for each monkey
    for ($j=0; $j < count($monkies); $j++) {
        // repeat for each item
        $monkeyItems = count($monkies[$j]->getItems());
        $monkies[$j]->setInspections($monkeyItems);
        for ($k=0; $k < $monkeyItems; $k++) { 
            $monkies[$j]->monkeyAction($monkies, $part);
        }
    }
}

// get number of inspections, sort on highest and multiply top two
foreach ($monkies as $monkey) {
    $inspections[$monkey->getId()] = $monkey->getInspections();
}
arsort($inspections);
$inspections = array_slice($inspections, 0, 2);
$monkeyBusiness = array_product($inspections);

echo 'After '. ROUNDS . ' rounds, the monkey business level is ' . $monkeyBusiness;


// ***** FUNCTIONS *****
function getMonkeyValues($line, $monkeyValues) {
    $values = array();

    if (preg_match('/Monkey (\d+)/', $line)) {
        preg_match('/Monkey (\d+)/', $line, $values);
        $monkeyValues[] = $values[1];
    }
    if (preg_match('/Starting items: ([0-9\,\s]+)/', $line)) {
        preg_match('/Starting items: ([0-9\,\s]+)/', $line, $values);
        $values[1] = explode(', ', $values[1]);
        $monkeyValues[] = $values[1];
    }
    if (preg_match('/Operation: new = old (.+)/', $line)) {
        preg_match('/Operation: new = old (.+)/', $line, $values);
        $values[1] = explode(' ', $values[1]);
        $monkeyValues[] = $values[1];
    }
    if (preg_match('/Test: divisible by (\d+)/', $line)) {
        preg_match('/Test: divisible by (\d+)/', $line, $values);
        $monkeyValues[] = $values[1];
    }
    if (preg_match('/If true: throw to monkey (\d+)/', $line)) {
        preg_match('/If true: throw to monkey (\d+)/', $line, $values);
        $monkeyValues[] = $values[1];
    }
    if (preg_match('/If false: throw to monkey (\d+)/', $line)) {
        preg_match('/If false: throw to monkey (\d+)/', $line, $values);
        $monkeyValues[] = $values[1];
    }

    return $monkeyValues;
}
