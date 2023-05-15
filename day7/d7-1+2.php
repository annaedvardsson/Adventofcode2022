<?php

class File {
    private $name;     //$name is never used
    private $size;
    private $directory;

    function __construct($name, $size, $directory) {
        $this->name = $name;
        $this->size = $size;
        $this->directory = $directory;
    }

    //Methods
    function get_size() {
        return $this->size;
    }
    function get_directory() {
        return $this->directory;
    }
}

//***** Main Program *****
$currDir = array();
$fileDir = "";
$files = array();
$folderSize = array();
$total = 0;


// $inputFile = fopen("d7_Example.txt", "r") or die("Unable to open file!");
$inputFile = fopen("d7_NoSpaceLeftOnDevice.txt", "r") or die("Unable to open file!");

    // read file line-by-line until end-of-file
    while (!feof($inputFile)) {
    // for ($q=0; $q < 200; $q++) {

        unset($lineSections);
        $line = trim(fgets($inputFile));
        $lineSections = explode(" ", $line);

        // monitor current directory
        if ($lineSections[1] == 'cd') {
            if ($lineSections[2] == '..') {
                array_pop($currDir);
            } else {
                array_push($currDir, ($lineSections[2]));
            }
        }

        // save file name, size and location   
        if (is_numeric($lineSections[0])) {
            $files[] = new File($lineSections[1], $lineSections[0], implode("/", $currDir));
        }
    }

fclose($inputFile);

// calculate file size per folder
foreach ($files as $file) {

    $fileDir = $file->get_directory();
    if (!isset($folderSize[$fileDir])) {
        $folderSize[$fileDir] = 0;
    }
    $folderSize[$fileDir] += $file->get_size();

    // add file size to all "upper" folders
    while ($fileDir[strlen($fileDir)-1] != "/") { 
        $fileDir = (substr($fileDir, 0, strrpos($fileDir, "/")));
        if (!isset($folderSize[$fileDir])) {
            $folderSize[$fileDir] = 0;
        }
        $folderSize[$fileDir] += $file->get_size();
    }
}

// sum folders which are <= 100000
foreach ($folderSize as $key => $value) {
    if ($value <= 100000) {
        $total +=  $value;
    }
}

// print final result(s)
echo "Total sum of folders <= 100 000: " . number_format($total, 0, ',', ' ') . "\n";

//Part 2
folderToDelete($folderSize);


// ***** Functions *****
function folderToDelete($folderSize) {
    define('TOTALSPACE', 70000000);
    define('REQUIREDSPACE', 30000000);

    $emptySpace = TOTALSPACE - $folderSize['/'];
    $spaceToDelete = REQUIREDSPACE - $emptySpace;
    
    asort($folderSize);
    foreach ($folderSize as $key => $value) {
        if ($value > $spaceToDelete) {
            echo 'Deleting folder ' . $key . ' will increase the unused space with ' . number_format($value, 0, '.', ' ');
            echo ' leaving a total of ' . number_format(($emptySpace + $value), 0, '.', ' ') . ' free space.';
            break;
        }    
    }
}