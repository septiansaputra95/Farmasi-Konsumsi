<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProsesSimpanKonsumsi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function simpanKonsumsi($namaPetugas, $fileTmp, $fileName, $konsumsiTanggal)
    {

        $tanggal = date('Y-m-d');
        // var_dump($fileUpload);die();
        // Nama Unik File Excell 
        $uniqueFileName = date('Ymd') . '' . rand(1,10000);
        $this->uploadFiles($uniqueFileName, $fileTmp);

        // Simpan Header Data
        $this->simpanHeader($uniqueFileName, $namaPetugas, $tanggal, $konsumsiTanggal);
        
        // Simpan data excell ke Database
        $this->simpanDetail($uniqueFileName, $tanggal);
    }

    private function generateUniqueId()
    {
        return uniqid();
    }

    private function simpanHeader($dataId, $namaPetugas, $tanggal, $konsumsiTanggal)
    {
        $dataArray = $this->loadFiles($dataId, $tanggal);
        $nilaibaris1kolom1 = $dataArray[1][1];
        //var_dump($dataArray[1][0]);die();
        $stmtHeader = $this->pdo->prepare("INSERT INTO pharmacy_consumption_header (data_id, nama_petugas, tanggal, konsumsi_tanggal) VALUES (?, ?, ?, ?)");
        $stmtHeader->execute([$dataId, $namaPetugas, $tanggal, $konsumsiTanggal]);
    }

    public function importDataFromExcel($filePath)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        $data = [];

        for ($row = 2; $row <= $highestRow; ++$row) {
            $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            $data[] = $rowData[0];
        }

        return $data;
    }

    public function uploadFiles($uniqueFileName, $fileTmp)
    {
        // Tentukan direktori tempat menyimpan file uploads
        $uploadDir = __DIR__ . '/uploads/';
        $uniqueFileName = $uniqueFileName.'.xls';
        // Pindahkan file ke direktori uploads dengan nama yang unik berdasarkan tanggal
        $uploadPath = $uploadDir . $uniqueFileName;
        
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            echo "File berhasil diupload. Path: " . $uploadPath;
        } else {
            echo "Gagal mengupload file.";
        }

    }

    public function loadFiles($uniqueFileName, $tanggal)
    {
        $inputFileName = './uploads/'.$uniqueFileName.'.xls';

        // Identify the type of $inputFileName
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

        // Create a new Reader of the type that has been identified
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        // Load $inputFileName to a Spreadsheet Object
        $spreadsheet = $reader->load($inputFileName);

        // Get the active sheet
        $activeSheet = $spreadsheet->getActiveSheet();

        // Convert the active sheet to an array
        return $dataArray = $activeSheet->toArray();
    }

    public function simpanDetail($uniqueFileName, $tanggal)
    {
        $inputFileName = './uploads/'.$uniqueFileName.'.xls';

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
        //echo '<br>'.substr($dataArray[2][5], 0,2);die;

        $sql = "
        INSERT INTO pharmacy_consumption(
            data_id,
            document_no,
            consumed_date,
            department,
            storename,
            tanggalinput
        )
        VALUES (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ";
        $stmt = $this->pdo->prepare("
        INSERT INTO pharmacy_consumption(
            data_id, 
            document_no, 
            consumed_date, 
            department, 
            storename, 
            mrn, 
            visit_no, 
            patient_name, 
            gender, 
            admitting_doctor, 
            tanggalinput,
            visit_type
            ) VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
        
        

        for($i=1; $i<count($dataArray); $i++){

            $data = [
                $uniqueFileName,
                $dataArray[$i][0],
                $dataArray[$i][1],
                $dataArray[$i][2],
                $dataArray[$i][3],
                $dataArray[$i][4],
                $dataArray[$i][5],
                $dataArray[$i][6],
                $dataArray[$i][7],
                $dataArray[$i][9],
                $tanggal,
                substr($dataArray[$i][5], 0,2)
            ];
            
            $query_execute = $stmt->execute($data);
            //var_dump($data, $query_execute);
        }
    }
    
}

// Include koneksi.php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $handler = new ProsesSimpanKonsumsi($pdo);


    // Ambil data dari form
    $namaPetugas = $_POST['nama_Petugas'];
    // Dapatkan nama file dan path sementara pada server
    $fileTmp = $_FILES['file_Upload']['tmp_name'];
    $fileName = $_FILES['file_Upload']['name'];
    $konsumsiTanggal = $_POST['konsumsi_tanggal'];
    // Upload Files
    // $handler->uploadFiles($fileTmp, $fileName);

    // Simpan konsumsi
    $handler->simpanKonsumsi($namaPetugas, $fileTmp, $fileName, $konsumsiTanggal);

     // Redirect ke halaman index.php dengan notifikasi
     header("Location: index.php?success=1");
     exit();
    echo "Data berhasil disimpan!";
} else {
    // Jika bukan metode POST, berikan respons sesuai kebutuhan
    echo "Permintaan tidak valid.";
}
?>
