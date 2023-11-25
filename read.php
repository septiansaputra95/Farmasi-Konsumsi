<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$inputFileName = './uploads/202311237496_28 AGUS.xls';

/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);
// Get the active sheet
$activeSheet = $spreadsheet->getActiveSheet();

// Define the column index you want to extract (e.g., column A = 1, column B = 2, etc.)
$columnIndex = 1; // Change this to the desired column

// Get the highest row number
$highestRow = $activeSheet->getHighestRow();

// Skip the first row (header)
$startRow = 2;

// Iterate through rows and collect values from the specified column
for ($row = $startRow; $row <= $highestRow; $row++) {
    $cellValue = $activeSheet->getCellByColumnAndRow($columnIndex, $row)->getValue();
    $columnArray[] = $cellValue;
}

// Display the array
echo '<pre>';
print_r($columnArray);
echo '</pre>';