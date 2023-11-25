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

    public function simpanKonsumsi($namaPetugas, $fileTmp, $fileName)
    {

        $tanggal = date('Y-m-d');
        // var_dump($fileUpload);die();
        // Nama Unik File Excell 
        $uniqueFileName = date('Ymd') . '' . rand(1,10000);
        $this->uploadFiles($uniqueFileName, $fileTmp);

        // Simpan Header Data
        $this->simpanHeader($uniqueFileName, $namaPetugas, $tanggal);
        
        // Simpan data excell ke Database
        $this->simpanDetail($uniqueFileName, $tanggal);
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

        //var_dump($dataArray[1]);die();
        // $sql = "
        //     INSERT INTO pharmacy_consumption(*)
        //     VALUES (
        //         data_id
        //         document_no
        //         consumed_date
        //         department
        //         storename
        //         mrn
        //         visit_no
        //         patient_name
        //         gender
        //         admitting_doctor
        //         treating_doctor
        //         document_type
        //         item_type
        //         item_category
        //         item_code
        //         item_name
        //         batch_no
        //         qty
        //         uom
        //         cost_rate
        //         cost_value
        //         sales_rate
        //         discount_amount
        //         net_sale_value
        //         tax_amount
        //         sales_value
        //         vendor
        //         tanggalinput

        //     )
        // ";

        // $sql = "
        //     INSERT INTO pharmacy_consumption(
        //         data_id,
        //         document_no,
        //         consumed_date,
        //         department,
        //         storename,
        //         tanngalinput
        //     )
        //     VALUES (
        //         :data_id,
        //         :document_no,
        //         :consumed_date,
        //         :department,
        //         :storename,
        //         :tanggalinput

        //     )
        // ";

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
        INSERT INTO pharmacy_consumption_copy1(
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
            tanggalinput
            ) VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
        // $stmt = $this->pdo->prepare("
        // INSERT INTO pharmacy_consumption
        // (
        //     data_id, 
        //     document_no, 
        //     consumed_date, 
        //     department, 
        //     storename,
        //     mrn,
        //     visit_no,
        //     patient_name,
        //     gender,
        //     admitting_doctor,
        //     treating_doctor,
        //     document_type,
        //     item_type,
        //     item_category,
        //     item_code,
        //     item_name,
        //     batch_no,
        //     qty,
        //     uom,
        //     cost_rate,
        //     cost_value,
        //     sales_rate,
        //     discount_amount,
        //     net_sale_value,
        //     tax_amount,
        //     sales_value,
        //     vendor, 
        //     tanggalinput
        // ) VALUES 
        // (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        // ");
        

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
                //$dataArray[$i][8],
                $dataArray[$i][9],
                // $dataArray[$i][10],
                // $dataArray[$i][11],
                // $dataArray[$i][12],
                // $dataArray[$i][13],
                // $dataArray[$i][14],
                // $dataArray[$i][15],
                // $dataArray[$i][16],
                // //$dataArray[$i][17],
                // $dataArray[$i][18],
                // $dataArray[$i][19],
                // $dataArray[$i][20],
                // $dataArray[$i][21],
                // $dataArray[$i][22],
                // $dataArray[$i][23],
                // $dataArray[$i][24],
                // $dataArray[$i][25],
                // $dataArray[$i][26],
                // $dataArray[$i][27],
                $tanggal
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

    // Upload Files
    // $handler->uploadFiles($fileTmp, $fileName);

    // Simpan konsumsi
    $handler->simpanKonsumsi($namaPetugas, $fileTmp, $fileName);

    // Setelah berhasil menyimpan, bisa diarahkan ke halaman lain atau memberikan respons sesuai kebutuhan
    echo "Data berhasil disimpan!";
} else {
    // Jika bukan metode POST, berikan respons sesuai kebutuhan
    echo "Permintaan tidak valid.";
}
?>
