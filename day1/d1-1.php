<?php

$topCal = PHP_INT_MIN;
$topElf = 0;
$sumCal = 0;
$currentElf = 0;

$file = fopen("d1_Example.txt", "r") or die("Unable to open file!");

	// line-by-line until end-of-file
	while (!feof($file)) {
      $currentCal = (int)trim(fgets($file));
		if ($currentCal != 0) {
         $sumCal = $sumCal + $currentCal;
		} else {
         $currentElf++;
         if ($topCal < $sumCal) {
            $topCal = $sumCal;
            $topElf = $currentElf;
         }
         $sumCal = 0;
      }
	}

fclose($file);

// check last elf
if ($topCal < $sumCal) {
   $currentElf++;
   $topCal = $sumCal;
   $topElf = $currentElf;
}   

echo 'Elf number ' . $topElf . ' is carrying most calories: ' . $topCal;