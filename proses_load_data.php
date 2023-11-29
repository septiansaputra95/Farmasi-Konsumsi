<?php
// Include koneksi.php atau file yang mengatur koneksi ke database
include 'koneksi.php';

// Panggil fungsi untuk mendapatkan data
$data = getDataFromDatabase($pdo);

// Kirim data sebagai respons JSON
echo json_encode($data);

// Fungsi untuk mendapatkan data dari database
function getDataFromDatabase($pdo) {
    $query = "SELECT data_id, konsumsi_tanggal, nama_petugas, tanggal FROM pharmacy_consumption_header";
    //$query = "SELECT data_id, nama_petugas, tanggal FROM pharmacy_consumption_header";
    $result = $pdo->query($query);

    return $result->fetchAll(PDO::FETCH_ASSOC);
}
?>
