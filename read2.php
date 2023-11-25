<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$inputFileName = './uploads/202311255400_new.xls';

// Identify the type of $inputFileName
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

// Create a new Reader of the type that has been identified
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

// Load $inputFileName to a Spreadsheet Object
$spreadsheet = $reader->load($inputFileName);

// Get the active sheet
$activeSheet = $spreadsheet->getActiveSheet();

// Convert the active sheet to an array
$dataArray = $activeSheet->toArray();

// Display the array
echo '<pre>';
print_r($dataArray[0]);
echo '</pre>';