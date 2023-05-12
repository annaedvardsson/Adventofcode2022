<?php

$sumCal = 0;
$currentElf = 0;

$file = fopen("d1_CalorieCounting.txt", "r") or die("Unable to open file!");

	// read file line-by-line until end-of-file
	while (!feof($file)) {
      $currentCal = (int)trim(fgets($file));
		if ($currentCal != 0) {
         $sumCal = $sumCal + $currentCal;
		} else {
         $currentElf++;
         $allElves[$currentElf] = $sumCal; 
         $sumCal = 0;
      }
   }
fclose($file);

// add last elf to array
$currentElf++;
$allElves[$currentElf] = $sumCal;

// sort array desc, keep top 3 and calculate sum
arsort($allElves);
$topCal = (array_slice($allElves, 0, 3, true));
$totalCal = array_sum($topCal);

// print result
echo 'Elves ';
   foreach ($topCal as $key => $value) {
      echo $key . ' (' . $value . ' cal), ';
   }
   echo 'carry most calories: ' . $totalCal . ' cal in total';