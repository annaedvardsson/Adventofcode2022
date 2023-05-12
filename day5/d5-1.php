<?php

$crates = array(array());

$file = fopen("d5_SupplyStacks.txt", "r") or die("Unable to open file!");

    // read crate drawing from file
    $crates = readCrateDrawing($file);
    
    // skip empty line between crate drawing and move instructions
    fgets($file);
    
    // exeute moves
    while (!feof($file)) {
        $line = trim(fgets($file));
        $crates = moveCrates($line, $crates);
    }

fclose($file);

echo 'Top crates: ';
for ($i=1; $i <= count($crates); $i++) { 
   echo $crates[$i][count($crates[$i]) - 1];
}


// ***** Functons *****
function readCrateDrawing($file) {
    $i = 0;
    do {
        $line = fgets($file);
        for ($j = 1; $j < strlen($line); $j += 4) {
            $crateDrawing[$i][] = $line[$j];
        }
        $i++;
    } while (!is_numeric($line[strlen($line) - 4]));

    $crateDrawing = array_reverse($crateDrawing);

    //Pivot to columns, set "position" as key and remove "empty" crate positions (see below for step by step example)
    $crates = array();
    foreach ($crateDrawing[0] as $colIndex => $colVal) {
        $newRow = array();
        foreach ($crateDrawing as $rowIndex => $rowVal) {
            $newVal = trim($crateDrawing[$rowIndex][$colIndex]);
            if (!empty($newVal) && !is_numeric($newVal)) {
                $newRow[] = $newVal;
            }
        }
        $crates[$colVal] = $newRow;
    }
    return $crates;
}

function moveCrates($line, $crates) {
    unset($values);

    preg_match('/(\d+).*?(\d+).*?(\d+)/', $line, $values);

    for ($j = 0; $j < $values[1]; $j++) {
        $move = array_pop($crates[$values[2]]);
        array_push($crates[$values[3]], $move);
    }

    return $crates;
}



// ***** EXTRA *****
    // //Pivot to columns, set "position" as key and remove "empty" positions (step by step)
    // echo "Pivot and position as keys\n";
    // $crates = array();
    // foreach ($crateDrawing[0] as $index => $value) {
    //     $temp = array();
    //     foreach ($crateDrawing as $row) {
    //         $temp[] = $row[$index];
    //     }
    //     $crates[$value] = $temp;
    // }
    // // var_dump($crates);

    // echo "Remove position from index 0\n";
    // foreach ($crates as &$crate) {
    //     unset($crate[0]);
    //     $crate = array_values($crate);
    // }
    // // var_dump($crates);

    // echo "Remove \"empty\" positions\n";
    // foreach ($crates as &$crate) {
    //     $i = count($crate) - 1;
    //     while ($crate[$i] === " " && $i >= 0) {
    //         unset($crate[$i]);
    //         $i--;
    //     }
    // }
