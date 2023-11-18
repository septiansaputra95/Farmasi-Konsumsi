<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ProsesSimpanKonsumsi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function simpanKonsumsi($namaPetugas, $fileUpload)
    {

        $dataId = $this->generateUniqueId();
        $tanggal = date('Y-m-d');

    
        $this->simpanHeader($dataId, $namaPetugas, $tanggal);
        
        // Import data dari Excel
        $importedData = $this->importDataFromExcel($fileUpload['tmp_name']);
        $this->simpanDetail($dataId, $fileUpload);
    }

    private function generateUniqueId()
    {
        return uniqid();
    }

    private function simpanHeader($dataId, $namaPetugas, $tanggal)
    {
        $stmtHeader = $this->pdo->prepare("INSERT INTO pharmacy_consumption_header (data_id, nama_petugas, tanggal) VALUES (?, ?, ?)");
        $stmtHeader->execute([$dataId, $namaPetugas, $tanggal]);
    }

    // private function simpanDetail($dataId, $fileUpload)
    // {
    //     $stmtDetail = $this->pdo->prepare("INSERT INTO pharmacy_consumption (data_id, file_name, file_type, file_content) VALUES (?, ?, ?, ?)");

    //     $fileName = $fileUpload['name'];
    //     $fileType = $fileUpload['type'];
    //     $fileContent = file_get_contents($fileUpload['tmp_name']);

    //     $stmtDetail->execute([$dataId, $fileName, $fileType, $fileContent]);
    // }
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

    public function simpanDetail($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pharmacy_consumption (
                data_id,
                file_name,
                file_type,
                file_content,
                document_no,
                consumed_date,
                department,
                storename,
                mrn,
                visit_no,
                patient_name,
                gender,
                admitting_doctor,
                treating_doctor,
                document_type,
                item_type,
                item_category,
                item_code,
                item_name,
                batch_no,
                qty,
                uom
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($data as $row) {
            $row[] = null; // Add a null placeholder for file-related columns
            $stmt->execute($row);
        }
    }
    
}

// Include koneksi.php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $handler = new ProsesSimpanKonsumsi($pdo);

    // Ambil data dari form
    $namaPetugas = $_POST['nama_Petugas'];
    $fileUpload = $_FILES['file_Upload'];

    // Simpan konsumsi
    $handler->simpanKonsumsi($namaPetugas, $fileUpload);

    // Setelah berhasil menyimpan, bisa diarahkan ke halaman lain atau memberikan respons sesuai kebutuhan
    echo "Data berhasil disimpan!";
} else {
    // Jika bukan metode POST, berikan respons sesuai kebutuhan
    echo "Permintaan tidak valid.";
}
?>
