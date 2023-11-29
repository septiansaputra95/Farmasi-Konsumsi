<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_id = $_POST['data_id'];
    $action = $_POST['action']; // Ambil nilai action
    if ($action === 'Resep') {
        // Panggil fungsi generateDataFromDatabase khusus untuk generateResep
        $result = generateDataFromDatabaseResep($pdo, $data_id);

        // Mengembalikan hasil generate sebagai respons JSON
        echo json_encode($result);
    } elseif ($action === 'SubResep')
    {
        // Panggil fungsi generateDataFromDatabase
        $result = generateDataFromDatabase($pdo, $data_id);

        // Mengembalikan hasil generate sebagai respons JSON
        echo json_encode($result);
        //echo $result;
    }
}

// Fungsi untuk generate data dari database
function generateDataFromDatabase($pdo, $data_id) {
    $gudang = ['FARMASI EXECUTIVE', 'FARMASI REGULER'];
    $jenis = ['OP', 'IP'];
    for($i=0; $i < count($gudang); $i++)
    {
        for($j=0; $j <count($jenis); $j++)
        {
             // Gunakan prepared statement untuk menghindari SQL injection
             $query = "SELECT * FROM pharmacy_consumption WHERE data_id = ? AND storename = ? AND visit_type = ?";
             $stmt = $pdo->prepare($query);
             $stmt->execute([$data_id, $gudang[$i], $jenis[$j]]);
             $hasil[] = $stmt->rowCount();
        }
    }
    
    $formatResult = "FARMASI EXECUTIVE OP = {$hasil[0]} | ";
    $formatResult .= "FARMASI EXECUTIVE IP = {$hasil[1]} | ";
    $formatResult .= "FARMASI REGULER OP = {$hasil[2]} | ";
    $formatResult .= "FARMASI REGULER IP = {$hasil[3]} | ";
    return $formatResult;
}

// Fungsi untuk generate data dari database
function generateDataFromDatabaseResep($pdo, $data_id) {
    $gudang = ['FARMASI EXECUTIVE', 'FARMASI REGULER'];
    $jenis = ['OP', 'IP'];
    for($i=0; $i < count($gudang); $i++)
    {
        for($j=0; $j <count($jenis); $j++)
        {
             // Gunakan prepared statement untuk menghindari SQL injection
             $query = "SELECT document_no FROM pharmacy_consumption WHERE data_id = ? AND storename = ? AND visit_type = ? GROUP BY document_no";
             $stmt = $pdo->prepare($query);
             $stmt->execute([$data_id, $gudang[$i], $jenis[$j]]);
             $hasil[] = $stmt->rowCount();
        }
    }
    
    $formatResult = "FARMASI EXECUTIVE OP = {$hasil[0]} | ";
    $formatResult .= "FARMASI EXECUTIVE IP = {$hasil[1]} | ";
    $formatResult .= "FARMASI REGULER OP = {$hasil[2]} | ";
    $formatResult .= "FARMASI REGULER IP = {$hasil[3]} | ";
    return $formatResult;
}